<?php
namespace console\controllers;

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
        // а также все разрешения роли "author"
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $manageUser);
        $auth->addChild($admin, $manageMessage);
        $auth->addChild($admin, $accessAdminArea);
        $auth->addChild($admin, $user);

        // Назначение ролей пользователям. 1 и 2 это IDs возвращаемые IdentityInterface::getId()
        // обычно реализуемый в модели User.
        $auth->assign($admin, 1);
    }
}