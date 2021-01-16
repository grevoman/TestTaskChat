<?php

use common\models\User;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget(
        [
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'columns'      => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'username',
                [
                    'label' => 'Роли',
                    'value' => function (User $model) {
                        $role = current(Yii::$app->authManager->getRolesByUser($model->id));

                        return $role ? $role->name : '';
                    },
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]
    ); ?>


</div>
