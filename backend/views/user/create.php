<?php

/* @var $this yii\web\View */
/* @var $model \backend\models\forms\UserForm */

$this->title = 'Create new user';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['page-header'] = $this->title;
?>
<div class="card">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
