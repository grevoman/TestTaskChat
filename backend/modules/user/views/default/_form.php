<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */

$rolesAsDropdown = [];
$auth = Yii::$app->authManager;
foreach ($auth->getRoles() as $key => $role) {
    $rolesAsDropdown[$key] = $role->name;
}
?>

<div class="user-form">

    <?php
    $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'status')->textInput() ?>
    <div class='form-group field-user-status'>
        <label class='control-label' for='user-status'>Роль</label>
        <?= Html::dropDownList(
            'role',
            $auth->getRolesByUser($model->id) ? current($auth->getRolesByUser($model->id))->name : '',
            $rolesAsDropdown,
            ['class' => 'form-control']
        ) ?>
        <div class='help-block'></div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php
    ActiveForm::end(); ?>

</div>
