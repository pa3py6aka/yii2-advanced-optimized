<?php

namespace frontend\widgets\ModalAuthWidget;


use yii\base\Widget;

class ModalAuthWidget extends Widget
{
    public function run(): string
    {
        ModalAuthAsset::register($this->view);

        $output = $this->render('login-modal', ['loginForm' => new \core\forms\auth\LoginForm()]);
        $output .= $this->render('signup-modal', ['signupForm' => new \core\forms\auth\SignupForm()]);
        $output .= $this->render('password-reset-modal', ['resetPasswordForm' => new \core\forms\auth\PasswordResetRequestForm]);

        return $output;
    }
}