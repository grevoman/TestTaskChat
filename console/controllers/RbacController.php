<?php
namespace console\controllers;

use common\models\User;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // добавляем разрешение "createMessage"
        $createMessage = $auth->createPermission('createMessage');
        $createMessage->description = 'Create a message';
        $auth->add($createMessage);

        // добавляем разрешение "manageUser"
        $manageUser = $auth->createPermission('manageUser');
        $manageUser->description = 'Manage User';
        $auth->add($manageUser);

        // добавляем разрешение "manageMessage"
        $manageMessage = $auth->createPermission('manageMessage');
        $manageMessage->description = 'Manage Message';
        $auth->add($manageMessage);

        // добавляем разрешение "accessAdminArea"
        $accessAdminArea = $auth->createPermission('accessAdminArea');
        $accessAdminArea->description = 'Access Admin Area';
        $auth->add($accessAdminArea);

        // добавляем роль "user" и даём роли разрешение "createMessage"
        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $createMessage);

        // добавляем роль "admin" и даём роли разрешение "manageUser", "manageMessage"
        // а также все разрешения роли "user"
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $manageUser);
        $auth->addChild($admin, $manageMessage);
        $auth->addChild($admin, $accessAdminArea);
        $auth->addChild($admin, $user);

        $userAdmin = User::findOne(['username' => 'admin']);
        $userUser = User::findOne(['username' => 'user']);
        $auth->assign($admin, $userAdmin->getId());
        $auth->assign($user, $userUser->getId());
    }
}