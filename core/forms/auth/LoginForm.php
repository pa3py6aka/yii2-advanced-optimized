<?php

namespace core\forms\auth;


use core\access\Rbac;
use common\models\User\User;
use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $email;
    public $password;
    public $foreignComputer;

    private $_user;

    public function rules(): array
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['password', 'string'],
            ['foreignComputer', 'boolean'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'email' => 'Email',
            'password' => 'Password',
            'foreignComputer' => 'Another\'s computer',
        ];
    }

    public function validate($attributeNames = null, $clearErrors = true): bool
    {
        if (parent::validate($attributeNames, $clearErrors)) {
            $user = $this->getUser();
            if ($user && !$user->password_hash) {
                $this->addError('password', 'Wrong email or/and password.');
            } else if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('password', 'Wrong email or/and password');
            } else if (Yii::$app->id === 'admin-cp' && !Yii::$app->authManager->checkAccess($user->id, Rbac::ROLE_MODERATOR)) {
                $this->addError('email', 'This account have not access to control panel.');
            }
        }
        return !$this->hasErrors();
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    public function getUser(): ?User
    {
        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }
}