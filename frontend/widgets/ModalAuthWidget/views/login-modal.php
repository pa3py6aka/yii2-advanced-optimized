<?php

use yii\bootstrap4\ActiveForm;

/* @var $loginForm \core\forms\auth\LoginForm */

?>
<div class="modal fade" tabindex="-1" role="dialog" id="login-modal">
    <div class="modal-dialog" role="document">
        <?php $form = ActiveForm::begin([
            'id' => 'form-login',
            'action' => ['/auth/login'],
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'validationUrl' => ['/auth/login-validation'],
        ]); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sign In</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <?= $form->field($loginForm, 'email')->input('email', ['placeholder' => 'Email'])->label(false) ?>
                    <?= $form->field($loginForm, 'password')->passwordInput(['placeholder' => 'Password'])->label(false) ?>
                    <?= $form->field($loginForm, 'foreignComputer')->checkbox() ?>

                    <div class="text-center">
                        <p style="font-size:16px;margin-bottom:16px;">- OR -</p>
                        <?= yii\authclient\widgets\AuthChoice::widget([
                            'baseAuthUrl' => ['/auth/by-network'],
                            'popupMode' => false,
                            'options' => ['class' => 'center-block']
                        ]) ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" data-toggle="modal" data-target="#password-reset-modal" class="mr-auto">I forgot my password</a>
                    <a href="#" data-toggle="modal" data-target="#signup-modal" style="margin-right:10px;">Sign Up</a>
                    <button type="submit" class="btn btn-primary">Sign In</button>

                </div>
            </div>
        <?php ActiveForm::end() ?>
    </div>
</div>
