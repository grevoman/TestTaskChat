<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m210111_170043_add_admin
 */
class m210111_170043_add_users extends Migration
{
    const USER_DATA = [
        'admin' => [
            'username' => 'admin',
            'email' => 'admin@localhost',
            'password' => 'adminadmin',
        ],
        'user' => [
            'username' => 'user',
            'email' => 'user@localhost',
            'password' => 'useruser',
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        foreach (self::USER_DATA as $role => $userData) {
            $user = new User();
            $user->username = $userData['username'];
            $user->email = $userData['email'];
            $user->setPassword($userData['password']);
            $user->generateAuthKey();
            $user->status = User::STATUS_ACTIVE;
            if (!$user->save()) {
                throw new \yii\db\Exception('Ошибка создания аккаунта ' . $role);
            }
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        foreach (self::USER_DATA as $role => $userData) {
            $user = User::findOne(['username' => $userData['username']]);
            $user->delete();
        }
    }
}
