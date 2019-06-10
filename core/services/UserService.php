<?php

namespace core\services;


use common\models\User\User;
use core\entities\User\UserNetwork;
use yii\authclient\OAuthToken;
use yii\db\Expression;
use yii\helpers\Json;

class UserService
{
    public static function updateNetworkInfo(UserNetwork $network, array $attributes)
    {
        if ($attributes) {
            $network->info = Json::encode($attributes);
        }
    }

    public function block(User $user)
    {
        $user->status = User::STATUS_INACTIVE;
        $user->block_time = new Expression('NOW()');
        if ($user->save()) {
            throw new \DomainException('Ошибка записи в базу.');
        }
    }
}