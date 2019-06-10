<?php

/* @var $this yii\web\View */
/* @var $user \common\models\User\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/password-reset', 'token' => $user->password_reset_token]);
?>
Hello <?= $user->username ?>,

Follow the link below to reset your password:

<?= $resetLink ?>
