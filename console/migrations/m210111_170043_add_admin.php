<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m210111_170043_add_admin
 */
class m210111_170043_add_admin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $user = new User();
        $user->username = 'admin';
        $user->auth_key = 'AQxn6JPMBSHHiARhOhFMfqNq2wo6ZZXo';
        $user->email = 'test@testtest.com';

        //Password - adminadmin
        $user->password_hash = '$2y$13$zTjhaYloQyCVuMj/Xy2Xhep7JJaRscxwyfONWK6LFypDT5S.VJ7.y';

        $user->status = User::STATUS_ACTIVE;
        if (!$user->save()) {
            throw new \yii\db\Exception('Ошибка создания аккаунта администратора');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $admin = User::findOne(['username' => 'admin']);
        if ($admin) {
            $admin->delete();
        }
    }
}
