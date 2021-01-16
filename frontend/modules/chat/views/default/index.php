<?php
/* @var $this yii\web\View */

/* @var $dataProvider MessageSearch */
/* @var $messageModel Message */

/* @var $model AddMessageForm */

use app\modules\chat\assets\ChatOnMainAsset;
use app\modules\chat\forms\AddMessageForm;
use common\models\Message;
use common\models\search\MessageSearch;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use yii\widgets\Pjax;

ChatOnMainAsset::register($this);
?>
<div class="chat-default-index">
    <a class='btn btn-info' href='/backend' role='button'>Админка</a>
    <div class='alert alert-info' role='alert'>
        Учётки: admin/adminadmin, user/useruser
    </div>
    <?php
    Pjax::begin(['id' => 'message-list-pjax']); ?>
    <table class='table'>
        <?= ListView::widget(
            [
                'dataProvider' => $dataProvider,
                'itemView'     => '_post',
                'id'           => 'chat-messages',
            ]
        ); ?>
    </table>
    <?php
    Pjax::end(); ?>
    <?php
    $form = ActiveForm::begin(
        [
            'id'      => 'add-message-form',
            'action'  => '',
            'options' => [
                'class' => 'form-horizontal',
                'data'  => [
                    'add-message-url'       => Url::to(['/chat/default/add-message']),
                    'incorrect-message-url' => Url::to(['/chat/default/incorrect-message']),
                ],
            ],
        ]
    ) ?>
    <?= $form->field($model, 'message') ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php
    ActiveForm::end() ?>
</div>
