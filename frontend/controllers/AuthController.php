<?php

namespace frontend\controllers;


use core\forms\auth\LoginForm;
use core\forms\auth\PasswordResetRequestForm;
use core\forms\auth\ResetPasswordForm;
use core\forms\auth\SignupForm;
use core\services\AuthService;
use core\forms\auth\VerifyEmailForm;
use core\forms\auth\ResendVerificationEmailForm;
use Yii;
use yii\authclient\AuthAction;
use yii\authclient\ClientInterface;
use yii\base\InvalidArgumentException;
use yii\base\Model;
use yii\base\Module;
use yii\bootstrap\ActiveForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;

class AuthController extends Controller
{
    private $service;

    public function __construct($id, Module $module, AuthService $service, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => [
                    'signup',
                    'signup-validation',
                    'password-reset-request',
                    'password-reset-request-validation',
                    'password-reset',
                    'login',
                    'login-validation',
                    'by-network',
                    'logout',
                ],
                'rules' => [
                    [
                        'actions' => [
                            'signup',
                            'signup-validation',
                            'password-reset-request',
                            'password-reset-request-validation',
                            'password-reset',
                            'login',
                            'login-validation',
                            'by-network',
                        ],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                    'signup' => ['post'],
                    'signup-validation' => ['post'],
                    'password-reset-request' => ['post'],
                    'password-reset-request-validation' => ['post'],
                    'login' => ['post'],
                    'login-validation' => ['post'],
                ],
            ],
        ];
    }

    public function actions(): array
    {
        return [
            'by-network' => [
                'class' => AuthAction::class,
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function actionSignup(): Response
    {
        $form = new SignupForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->service->signup($form);
            Yii::$app->session->setFlash('success', 'Please check your email to verify registration.');
            return $this->goBack();
        }
        if ($form->hasErrors()) {
            Yii::$app->session->setFlash('error', implode('<br>', $form->getErrorSummary(false)));
        }
        return $this->goBack();
    }

    public function actionSignupValidation(): ?array
    {
        $model = new SignupForm();
        return $this->ajaxValidation($model);
    }

    public function actionLogin(): Response
    {
        $form = new LoginForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            Yii::$app->user->login($form->getUser(), !$form->foreignComputer ? Yii::$app->params['user.sessionTime'] : 60 * 20);
            return $this->goBack();
        }

        if ($form->hasErrors()) {
            Yii::$app->session->setFlash('error', implode('<br>', $form->getErrorSummary(false)));
        }
        return $this->goBack();
    }

    public function actionLoginValidation(): ?array
    {
        $model = new LoginForm();
        return $this->ajaxValidation($model);
    }

    public function actionPasswordResetRequest(): Response
    {
        $form = new PasswordResetRequestForm();
        if ($form->load(Yii::$app->request->post()) & $form->validate()) {
            try {
                $this->service->resetPasswordRequest($form->email);
                Yii::$app->session->setFlash('success', 'Новый пароль отправлен на Ваш E-mail!');
                return $this->goBack();
            } catch (\DomainException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
                return $this->goBack();
            }
        }
        Yii::$app->session->setFlash('error', $form->getFirstError('email'));
        return $this->goBack();
    }

    public function actionPasswordResetRequestValidation(): ?array
    {
        $model = new PasswordResetRequestForm();
        return $this->ajaxValidation($model);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionPasswordReset($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionLogout(): Response
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * @param $model Model
     * @return array|null
     */
    private function ajaxValidation($model): ?array
    {
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        return null;
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token): Response
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    public function onAuthSuccess(ClientInterface $client): void
    {
        try {
            $user = $this->service->authByNetwork($client);
            Yii::$app->user->login($user, Yii::$app->params['user.sessionTime']);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }
}