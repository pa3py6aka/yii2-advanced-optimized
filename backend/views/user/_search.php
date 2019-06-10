<?php

use backend\assets\InputMaskAsset;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use common\models\User\User;

/* @var $this yii\web\View */
/* @var $model backend\models\search\UserSearch */
/* @var $form yii\widgets\ActiveForm */

InputMaskAsset::register($this);
?>
<div class="row">
    <div class="col m-3 card">
        <?php $form = ActiveForm::begin(['options' => ['class' => 'mt-3']]); ?>

        <?= $form->field($model, 'username') ?>

        <?= $form->field($model, 'email')->input('email') ?>

        <?= $form->field($model, 'status')->dropDownList(User::statusesArray()) ?>

        <?= $form->field($model, 'created_at')->textInput([
            'data-mask' => '0000-00-00',
            'placeholder' => 'YYYY-MM-DD',
            'data-mask-clearifnotmatch' => 'true'
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
