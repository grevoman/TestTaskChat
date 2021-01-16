<?php

use common\models\Message;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Некорректные сообщения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'filterModel' => $searchModel,
                             'columns' => [
                                 ['class' => 'yii\grid\SerialColumn'],

                                 'id',
                                 'text:ntext',
                                 [
                                     'attribute' => 'created_by',
                                     'value' => function (Message $model) {
                                         return $model->userRelation ? $model->userRelation->username : '';
                                     },
                                 ],
                                 [
                                     'attribute' => 'is_incorrect',
                                     'value' => function (Message $model) {
                                         return $model::getMessageStatus()[$model->is_incorrect];
                                     },
                                 ],
                                 'created_at:datetime',
                                 'updated_at:datetime',

                                 ['class' => 'yii\grid\ActionColumn'],
                             ],
                         ]); ?>

    <?php Pjax::end(); ?>

</div>
