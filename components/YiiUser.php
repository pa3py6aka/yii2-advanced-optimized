<?php

namespace components;

use yii\web\User;

/**
 * @inheritdoc
 *
 * @property \common\models\User\User|\yii\web\IdentityInterface|null $identity The identity object associated with the currently logged-in user. null is returned if the user is not logged in (not authenticated).
 */
class YiiUser extends User
{
}