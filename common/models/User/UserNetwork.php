<?php

namespace common\models\User;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%user_networks}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $identity
 * @property string $network
 * @property string $info
 *
 * @property User $user
 */
class UserNetwork extends ActiveRecord
{
    /**
     * @param $id
     * @param $identity
     * @param $network
     * @param null|array $info
     * @return UserNetwork
     */
    public static function create($id, $identity, $network, $info = null): UserNetwork
    {
        $userNetwork = new self();
        $userNetwork->user_id = $id;
        $userNetwork->identity = $identity;
        $userNetwork->network = $network;
        $userNetwork->info = $info;
        return $userNetwork;
    }

    public function afterFind()
    {
        $this->info = Json::decode($this->info);
        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->info = $this->info ? Json::encode((array) $this->info) : null;
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%user_networks}}';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'identity' => 'Identity',
            'network' => 'Network',
        ];
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
