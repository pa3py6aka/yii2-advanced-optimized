<?php

/* @var $this \yii\web\View */
/* @var $content string */

use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!doctype html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap d-flex flex-column">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-expand-md navbar-dark bg-dark',
        ],
    ]);
    $leftMenuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'About', 'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']],
    ];

    if (Yii::$app->user->isGuest) {
        $rightMenuItems[] = ['label' => 'Signup', 'url' => '#', 'linkOptions' => ['data-toggle' => 'modal', 'data-target' => '#signup-modal']];
        $rightMenuItems[] = ['label' => 'Login', 'url' => '#', 'linkOptions' => ['data-toggle' => 'modal', 'data-target' => '#login-modal']];
    } else {
        $rightMenuItems[] = '<li>'
            . Html::beginForm(['/auth/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'nav-link btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav mr-auto'],
        'items' => $leftMenuItems,
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => $rightMenuItems,
    ]);
    NavBar::end();
    ?>

    <main class="flex-fill" role="main">
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>
    <footer class="container">
        <hr>
        <p class="float-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="float-right"><?= Yii::powered() ?></p>
    </footer>
</div>

<?php if (Yii::$app->user->isGuest) {
    echo \frontend\widgets\ModalAuthWidget\ModalAuthWidget::widget();
} ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>