<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="display-1 text-muted mb-5"><i class="si si-exclamation"></i> <?= $exception->statusCode ?></div>
<h1 class="h2 mb-3"><?= nl2br(Html::encode($message)) ?></h1>
<p class="h4 text-muted font-weight-normal mb-7">
    <?= $exception->statusCode !== 404 ? 'Your custom message to users.' : 'This page does not exists.' ?>
</p>
<a class="btn btn-primary" href="javascript:history.back()">
    <i class="fe fe-arrow-left mr-2"></i>Go back
</a>
