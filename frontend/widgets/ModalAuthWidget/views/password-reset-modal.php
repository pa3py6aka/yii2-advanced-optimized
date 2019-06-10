<?php

use yii\bootstrap4\ActiveForm;

/* @var $resetPasswordForm \core\forms\auth\PasswordResetRequestForm */

?>
<div class="modal fade" tabindex="-1" role="dialog" id="password-reset-modal">
    <div class="modal-dialog" role="document">
        <?php $form = ActiveForm::begin([
            'id' => 'password-reset-form',
            'action' => ['/auth/password-reset-request'],
            'enableAjaxValidation' => true,
            'validationUrl' => ['/auth/password-reset-request-validation'],
        ]); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Password Reset</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <?= $form->field($resetPasswordForm, 'email')
                            ->input('email', ['placeholder' => 'Input your email']) ?>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </div>
        <?php ActiveForm::end() ?>
    </div>
</div>
