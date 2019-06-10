<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use common\models\User\User;

/* @var $this yii\web\View */
/* @var $model \backend\models\forms\UserForm */
/* @var $form yii\bootstrap4\ActiveForm */

?>

<div class="row">
    <div class="col m-3">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'username') ?>

        <?= $form->field($model, 'email')->input('email') ?>

        <?= $form->field($model, 'password')
                ->passwordInput()
                ->hint(!$model->user ? 'If left blank, the current password will not change' : '') ?>

        <?= $form->field($model, 'status')->dropDownList(User::statusesArray()) ?>

        <div class="form-group">
            <label for="" class="form-label">Roles</label>
            <div class="selectgroup selectgroup-pills">
                <?= Html::activeCheckboxList($model, 'roles', Yii::$app->authManager->getRoles(), [
                    'unselect' => null,
                    'item' => function ($index, $label, $name, $checked, $value) {
                        ?>
                        <label class="selectgroup-item">
                            <input type="checkbox" name="<?= $name ?>" value="<?= $value ?>" class="selectgroup-input"<?= $checked ? ' checked=""' : '' ?>>
                            <span class="selectgroup-button"><?= $value ?></span>
                        </label>
                        <?php
                    }
                ]) ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>