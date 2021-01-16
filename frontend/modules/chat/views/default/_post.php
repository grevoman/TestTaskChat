<?php

use common\models\Message;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

/* @var $model Message */

$isAdminMessage = in_array('admin', array_keys(Yii::$app->authManager->getRolesByUser($model->created_by)));
$isIncorrectMessage = (bool)$model->is_incorrect;

$styleAdminMessage = 'admin-message';
$styleIncorrectMessage = 'danger';

?>
<tr class="<?= $isIncorrectMessage ? $styleIncorrectMessage : '' ?>">
    <td>
        <?= $model->userRelation ? $model->userRelation->username : '' ?>:</div>
    </td>
    <td class="<?= $isAdminMessage ? $styleAdminMessage : '' ?>">
        <?= HtmlPurifier::process($model->text) ?>
    </td>
    <?php
    if (Yii::$app->user->can('manageMessage')): ?>
        <td>
            <?php
            if (!$model->is_incorrect): ?>
                <?= Html::button(
                    'Скрыть',
                    ['class' => 'btn btn-danger mark-incorrect', 'data' => ['id' => $model->id]]
                ) ?>
            <?php
            endif; ?>
        </td>
    <?php
    endif; ?>
</tr>