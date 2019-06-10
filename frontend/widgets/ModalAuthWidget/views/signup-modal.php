<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

/* @var $signupForm \core\forms\auth\SignupForm */

?>
<div class="modal fade" tabindex="-1" role="dialog" id="signup-modal">
    <div class="modal-dialog" role="document">
        <?php $form = ActiveForm::begin([
            'id' => 'form-signup',
            'action' => ['/auth/signup'],
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'validationUrl' => ['/auth/signup-validation'],
        ]); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                    <?= $form->field($signupForm, 'username')->textInput() ?>

                    <?= $form->field($signupForm, 'email') ?>

                    <?= $form->field($signupForm, 'password')->passwordInput() ?>

                    <?= $form->field($signupForm, 'agreement', ['enableAjaxValidation' => false])
                        ->checkbox(['label' => 'I agree with <a href="' . Url::to(['/pages/rules']) . '">terms and conditions</a>.']) ?>

                </div>
                <div class="modal-footer">
                    <a href="#" style="margin-right: 20px;" data-toggle="modal" data-target="#login-modal">Sign In</a>
                    <button type="submit" class="btn btn-primary">Sign Up</button>
                </div>
            </div><!-- /.modal-content -->
        <?php ActiveForm::end() ?>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
