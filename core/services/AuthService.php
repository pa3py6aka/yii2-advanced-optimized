<?php

namespace core\services;


use common\models\User\UserNetwork;
use core\access\Rbac;
use common\models\User\User;
use core\forms\auth\SignupForm;
use Yii;
use yii\authclient\ClientInterface;
use yii\authclient\OAuthToken;
use yii\base\UserException;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class AuthService
{
    private $transaction;

    public function __construct()
    {
        $this->transaction = new TransactionManager();
    }

    public function signup(SignupForm $form): void
    {
        $this->transaction->wrap(function () use ($form) {
            $user = User::create($form->username, $form->email, $form->password);
            $user->generateEmailVerificationToken();
            $user->status = User::STATUS_INACTIVE;
            if (!$user->save()) {
                throw new \RuntimeException('User saving error.');
            }

            if (
                !Yii::$app
                    ->mailer
                    ->compose(
                        ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                        ['user' => $user]
                    )
                    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                    ->setTo($user->email)
                    ->setSubject('Account registration at ' . Yii::$app->name)
                    ->send()
            ) {
                throw new \RuntimeException('Error while sending verification email.');
            }
        });
    }

    /**
     * @param User $user
     * @return User|null
     */
    public function verifyEmail(User $user): ?User
    {
        $user->status = User::STATUS_ACTIVE;
        return $user->save(false) ? $user : null;
    }

    public function resetPasswordRequest($email): void
    {
        $user = User::findByEmail($email);
        if (!$user) {
            throw new NotFoundHttpException('User does not exists.');
        }

        $this->transaction->wrap(function () use ($user) {
            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
                if (!$user->save()) {
                    throw new \RuntimeException('User saving error.');
                }

                if (
                !Yii::$app
                    ->mailer
                    ->compose(
                        ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                        ['user' => $user]
                    )
                    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                    ->setTo($user->email)
                    ->setSubject('Password reset for ' . Yii::$app->name)
                    ->send()
                ) {
                    throw new \RuntimeException('Error while sending password reset email.');
                }
            } else {
                throw new \DomainException('Sorry, we are unable to reset password for the provided email address.');
            }
        });
    }

    private function generatePassword(): string
    {
        return Yii::$app->security->generateRandomString(10);
    }

    public function authByNetwork(ClientInterface $client): User
    {
        $network = $client->getId();
        $attributes = $client->getUserAttributes();
        $identity = ArrayHelper::getValue($attributes, 'id');

        // Sign in
        if ($user = User::findIdentityByNetwork($network, $identity)) {
            if (!$user->isActive()) {
                throw new \DomainException('User not active.');
            }
            return $user;
        }

        $email = ArrayHelper::getValue($attributes, 'email');
        $username = ArrayHelper::getValue($attributes, 'login');

        // If email exists in base, show information about this
        if ($email && $user = User::findByEmail($email, false)) {
            throw new \DomainException("User with the same email as in {$client->getTitle()} account already exists but isn't linked to it. Login using email first to link it.");
        }

        // Create new user account
        $this->transaction->wrap(function () use ($email, $username, $network, $identity, $attributes) {
            $user = User::create($username, $email, null);
            if (!$user->save()) {
                throw new \RuntimeException('User saving error.');
            }

            $userNetwork = UserNetwork::create($user->id, $identity, $network, $attributes);
            if (!$userNetwork->save()) {
                throw new \RuntimeException('User network saving error.');
            }
        });

        return $user;
    }
}