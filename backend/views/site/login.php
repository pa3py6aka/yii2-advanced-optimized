<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \core\forms\auth\LoginForm */

use yii\bootstrap4\ActiveForm;

$this->title = 'Control Panel | Sign in';
?>
<div class="col col-login mx-auto">
    <div class="text-center mb-6">
        <h3><?= Yii::$app->name ?></h3>
        Control panel
    </div>
    <?php $form = ActiveForm::begin(['options' => ['class' => 'card']]); ?>
        <div class="card-body p-6">
            <?= $form->field($model, 'email')->input('email') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'foreignComputer')->checkbox() ?>

            <div class="form-footer">
                <button type="submit" class="btn btn-primary btn-block">Sign in</button>
            </div>
        </div>
    <?php ActiveForm::end() ?>
</div>
