<?php

use common\models\User;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(
            'Delete',
            ['delete', 'id' => $model->id],
            [
                'class' => 'btn btn-danger',
                'data'  => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method'  => 'post',
                ],
            ]
        ) ?>
    </p>

    <?= DetailView::widget(
        [
            'model'      => $model,
            'attributes' => [
                'id',
                'username',
                'email:email',
                [
                    'attribute' => 'status',
                    'value'     => function (User $model) {
                        return $model->getStatusAsString();
                    },
                ],
                [
                    'label' => 'Роль',
                    'value' => function (User $model) {
                        return current(Yii::$app->authManager->getRolesByUser($model->id))->name;
                    },
                ],
            ],
        ]
    ) ?>

</div>
