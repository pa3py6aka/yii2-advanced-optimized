<?php

namespace backend\helpers;


use common\models\User\User;
use core\access\Rbac;
use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;
use yii\rbac\Role;

class UserHelper
{
    /**
     * User status badge
     * @param $status
     * @return string
     */
    public static function getStatusBadge($status): string
    {
        switch ($status) {
            case User::STATUS_ACTIVE:
                $color = 'success';
                break;
            case User::STATUS_INACTIVE:
                $color = 'warning';
                break;
            case User::STATUS_DELETED:
                $color = 'secondary';
                break;
            default: $color = 'danger';
        }

        return Html::tag('span', ArrayHelper::getValue(User::statusesArray(), $status, 'Not set'), ['class' => "badge badge-pill badge-{$color}"]);
    }

    /**
     * Role badge
     * @param Role $role
     * @return string
     */
    public static function getRoleBadge(Role $role): string
    {
        switch ($role->name) {
            case Rbac::ROLE_ADMIN:
                $color = 'success';
                break;
            case Rbac::ROLE_USER:
                $color = 'primary';
                break;
            case Rbac::ROLE_MODERATOR:
                $color = 'info';
                break;
            default: $color = 'danger';
        }

        return Html::tag('span', $role->name, ['class' => "badge badge-pill badge-{$color}"]);
    }
}