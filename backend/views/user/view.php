<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;
use common\models\User\User;
use backend\helpers\UserHelper;

/* @var $this yii\web\View */
/* @var $model User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Remove this user?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="card">
        <?= DetailView::widget([
            //'options' => ['class' => 'card table table-striped table-bordered detail-view'],
            'model' => $model,
            'attributes' => [
                'id',
                'username',
                'email:email',
                [
                    'attribute' => 'status',
                    'value' => function (User $user) {
                        return UserHelper::getStatusBadge($user->status);
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'Roles',
                    'value' => function (User $user) {
                        return Html::ul(array_map(function (\yii\rbac\Role $role) {
                            return UserHelper::getRoleBadge($role);
                        }, Yii::$app->authManager->getRolesByUser($user->id)), [
                            'style' => 'list-style:none;margin:0;padding:0;',
                            'encode' => false,
                            'itemOptions' => ['class' => 'd-inline']
                        ]);
                    },
                    'format' => 'raw',
                ],
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]) ?>
    </div>


</div>
