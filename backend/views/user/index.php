<?php

use backend\assets\InputMaskAsset;
use yii\grid\ActionColumn;
use yii\bootstrap4\Html;
use yii\grid\GridView;
use common\models\User\User;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
$this->params['page-header'] = $this->title;

InputMaskAsset::register($this);
?>
<?php $this->beginBlock('tools') ?>
    <?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?>
<?php $this->endBlock() ?>

<?php //= $this->render('_search', ['model' => $searchModel]) ?>

<div class="col-12 card table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => \yii\grid\SerialColumn::class],

            //'id',
            'username',
            'email:email',
            [
                'attribute' => 'created_at',
                'format' => 'date',
                //'filter' => Consultant::CITIES,
                'filterInputOptions' => [
                    'data-mask' => '0000-00-00',
                    'placeholder' => 'YYYY-MM-DD',
                    'data-mask-clearifnotmatch' => 'true',
                    'class' => 'form-control'
                ]
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => User::statusesArray(),
                'value' => function (User $user) {
                    return \backend\helpers\UserHelper::getStatusBadge($user->status);
                }
            ],

            ['class' => ActionColumn::class],
        ],
    ]); ?>
</div>
