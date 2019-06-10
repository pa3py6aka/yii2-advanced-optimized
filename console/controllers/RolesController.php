<?php
namespace console\controllers;

use common\models\User\User;
use Yii;
use yii\console\Controller;
use yii\console\Exception;
use yii\helpers\ArrayHelper;

/**
 * Interactive console roles manager
 */
class RolesController extends Controller
{
    /**
     * Adds role to user
     */
    public function actionAssign()
    {
        $email = $this->prompt('Email:', ['required' => true]);
        $user = $this->findModel($email);
        $roleName = $this->select('Роль:', ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description'));
        $authManager = Yii::$app->authManager;
        $role = $authManager->getRole($roleName);
        $authManager->assign($role, $user->id);
        $this->stdout('Done!' . PHP_EOL);
    }

    /**
     * Removes role from user
     */
    public function actionRevoke()
    {
        $email = $this->prompt('Email:', ['required' => true]);
        $user = $this->findModel($email);
        $roleName = $this->select('Role:', ArrayHelper::merge(
            ['all' => 'All roles'],
            ArrayHelper::map(Yii::$app->authManager->getRolesByUser($user->id), 'name', 'description'))
        );
        $authManager = Yii::$app->getAuthManager();
        if ($roleName === 'all') {
            $authManager->revokeAll($user->id);
        } else {
            $role = $authManager->getRole($roleName);
            $authManager->revoke($role, $user->id);
        }
        $this->stdout('Done!' . PHP_EOL);
    }

    /**
     * @param string $email
     * @throws \yii\console\Exception
     * @return User the loaded model
     */
    private function findModel($email): User
    {
        if (!$model = User::findOne(['email' => $email])) {
            throw new Exception('User is not found');
        }
        return $model;
    }
}