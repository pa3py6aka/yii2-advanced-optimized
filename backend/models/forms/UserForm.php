<?php

namespace backend\models\forms;


use common\models\User\User;
use core\access\Rbac;
use Yii;
use yii\base\Model;
use yii\rbac\Role;

class UserForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $status = User::STATUS_ACTIVE;
    public $roles = [Rbac::ROLE_USER];

    /* @var User|null $user */
    public $user;

    public function __construct(User $user = null, array $config = [])
    {
        if ($user) {
            $this->username = $user->username;
            $this->email = $user->email;
            $this->status = $user->status;
            $this->roles = array_map(function (Role $role) {
                return $role->name;
            }, Yii::$app->authManager->getRolesByUser($user->id));
        }

        $this->user = $user;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['username', 'email'], 'trim'],
            [['username', 'email'], 'string', 'max' => 255],
            [['username'], 'default', 'value' => ''],
            [['email', 'status'], 'required'],
            ['email', 'email'],
            ['status', 'in', 'range' => array_keys(User::statusesArray())],
            ['roles', 'each', 'rule' => ['in', 'range' => array_map(function (Role $role) {
                return $role->name;
            }, Yii::$app->authManager->getRoles())]],

            ['password', 'required', 'when' => function () {
                return !$this->user;
            }, 'whenClient' => 'function(attribute, value) {
                return ' . ($this->user ? 'false' : 'true') . ';
            }'],
        ];
    }

    public function saveUser(): void
    {
        if (!$this->user) {
            $this->user = User::create($this->username, $this->email, $this->password);
        } else {
            $this->user->username = $this->username;
            $this->user->email = $this->email;
            if ($this->password) {
                $this->user->setPassword($this->password);
            }
        }

        $this->user->status = $this->status;

        if (!$this->user->save()) {
            throw new \RuntimeException('User saving error.');
        }

        // Assign RBAC roles
        Yii::$app->authManager->revokeAll($this->user->id);
        foreach ($this->roles as $roleName) {
            Yii::$app->authManager->assign(Yii::$app->authManager->getRole($roleName), $this->user->id);
        }
    }
}