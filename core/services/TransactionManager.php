<?php

namespace core\services;


class TransactionManager
{
    public function wrap(callable $function)
    {
        $transaction = \Yii::$app->db->beginTransaction(\yii\db\Transaction::REPEATABLE_READ);
        try {
            $function();
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}