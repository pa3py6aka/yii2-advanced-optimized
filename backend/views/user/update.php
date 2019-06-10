<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model \backend\models\forms\UserForm */

$this->title = $model->user->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '#' . $model->user->id, 'url' => ['view', 'id' => $model->user->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['page-header'] = Html::encode($this->title);
?>
<div class="card">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
