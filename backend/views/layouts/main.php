<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!doctype html>
<html lang="<?= Yii::$app->language ?>" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="#4188c9">
    <meta http-equiv="Content-Language" content="<?= Yii::$app->language ?>" />
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="icon" href="./favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" />

    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php $this->registerCsrfMetaTags() ?>

    <script src="/js/require.min.js"></script>
    <script>
        requirejs.config({
            baseUrl: '/'
        });
    </script>
</head>
<body>
<?php $this->beginBody() ?>

<div class="page">
    <div class="flex-fill">
        <div class="header py-4">
            <div class="container">
                <div class="d-flex">
                    <a class="header-brand" href="/">
                        <?= Yii::$app->name ?><span class="d-none d-sm-inline text-secondary">: Control panel</span>
                    </a>
                    <div class="d-flex order-lg-2 ml-auto">
                        <div class="nav-item d-none d-md-flex">
                            <a href="<?= Yii::$app->frontendUrlManager->createAbsoluteUrl('/') ?>" class="btn btn-sm btn-outline-primary" target="_blank">Go to site</a>
                        </div>

                        <?php /*
                        <div class="dropdown d-none d-md-flex">
                            <a class="nav-link icon" data-toggle="dropdown">
                                <i class="fe fe-bell"></i>
                                <span class="nav-unread"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                <a href="#" class="dropdown-item d-flex">
                                    <span class="avatar mr-3 align-self-center" style="background-image: url(demo/faces/male/41.jpg)"></span>
                                    <div>
                                        <strong>Nathan</strong> pushed new commit: Fix page load performance issue.
                                        <div class="small text-muted">10 minutes ago</div>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item d-flex">
                                    <span class="avatar mr-3 align-self-center" style="background-image: url(demo/faces/female/1.jpg)"></span>
                                    <div>
                                        <strong>Alice</strong> started new task: Tabler UI design.
                                        <div class="small text-muted">1 hour ago</div>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item d-flex">
                                    <span class="avatar mr-3 align-self-center" style="background-image: url(demo/faces/female/18.jpg)"></span>
                                    <div>
                                        <strong>Rose</strong> deployed new version of NodeJS REST Api V3
                                        <div class="small text-muted">2 hours ago</div>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item text-center">Mark all as read</a>
                            </div>
                        </div>
                        */ ?>

                        <div class="dropdown">
                            <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                                <span class="avatar fa fa-user"></span>
                                <span class="ml-2 d-none d-lg-block">
                                    <span class="text-default"><?= Yii::$app->user->identity->username ?></span>
                                    <small class="text-muted d-block mt-1"><?= Yii::$app->user->identity->email ?></small>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">

                                <?php /*  You can use this dropdown widgets.
                                <a class="dropdown-item" href="#">
                                    <i class="dropdown-icon fe fe-user"></i> Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="dropdown-icon fe fe-settings"></i> Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <span class="float-right"><span class="badge badge-primary">6</span></span>
                                    <i class="dropdown-icon fe fe-mail"></i> Inbox
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="dropdown-icon fe fe-send"></i> Message
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">
                                    <i class="dropdown-icon fe fe-help-circle"></i> Need help?
                                </a> */ ?>

                                <a class="dropdown-item" href="<?= Url::to(['/site/logout']) ?>" data-method="post">
                                    <i class="dropdown-icon fe fe-log-out"></i> Logout
                                </a>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                        <span class="header-toggler-icon"></span>
                    </a>
                </div>
            </div>
        </div>

        <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg order-lg-first">
                        <?= \yii\bootstrap4\Nav::widget([
                                'options' => ['class' => 'nav nav-tabs border-0 flex-column flex-lg-row'],
                                'encodeLabels' => false,
                                'items' => [
                                    ['label' => '<i class="fe fe-home"></i> Main', 'url' => ['/site/index']],
                                    ['label' => '<i class="fe fe-users"></i> Users', 'url' => ['/user/index'], 'active' => $this->context->id === 'user'],
                                ]
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="my-3 my-md-5">
            <div class="container">
                <?= \backend\widgets\Alert::widget() ?>
                <?php //= isset($this->params['breadcrumbs']) ? \yii\bootstrap4\Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) : '' ?>

                <?php if (isset($this->params['page-header'])) {
                    ?>
                    <div class="page-header justify-content-between">
                        <h1 class="page-title"><?= $this->params['page-header'] ?></h1>
                        <?php if (isset($this->blocks['tools'])): ?>
                            <div class="float-right">
                                <?= $this->blocks['tools'] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php
                } ?>

                <?= $content ?>
            </div>
        </div>
    </div>
    <?php /*
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-6 col-md-3">
                            <ul class="list-unstyled mb-0">
                                <li><a href="#">First link</a></li>
                                <li><a href="#">Second link</a></li>
                            </ul>
                        </div>
                        <div class="col-6 col-md-3">
                            <ul class="list-unstyled mb-0">
                                <li><a href="#">Third link</a></li>
                                <li><a href="#">Fourth link</a></li>
                            </ul>
                        </div>
                        <div class="col-6 col-md-3">
                            <ul class="list-unstyled mb-0">
                                <li><a href="#">Fifth link</a></li>
                                <li><a href="#">Sixth link</a></li>
                            </ul>
                        </div>
                        <div class="col-6 col-md-3">
                            <ul class="list-unstyled mb-0">
                                <li><a href="#">Other link</a></li>
                                <li><a href="#">Last link</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-4 mt-lg-0">
                    Premium and Open Source dashboard template with responsive and high quality UI. For Free!
                </div>
            </div>
        </div>
    </div>
    */ ?>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-12 mt-0">
                    Copyright © <?= date('Y') . ' ' . Yii::$app->name ?>. All rights reserved.
                </div>
            </div>
        </div>
    </footer>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
