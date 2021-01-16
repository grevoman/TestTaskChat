<?php

namespace app\modules\chat\controllers;

use app\modules\chat\forms\AddMessageForm;
use common\models\Message;
use common\models\search\MessageSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

/**
 * Default controller for the `chat` module
 */
class DefaultController extends Controller
{
    /**
     * @return array|array[]
     */
    public function behaviors()
    {
        return [
            'verbs'  => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'index'             => ['GET'],
                    'add-message'       => ['POST'],
                    'incorrect-message' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'only'  => ['add-message', 'incorrect-message'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['add-message'],
                        'roles'   => ['createMessage'],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['incorrect-message'],
                        'roles'   => ['manageMessage'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MessageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new AddMessageForm();
        $messageModel = new Message();

        return $this->render(
            'index',
            ['dataProvider' => $dataProvider, 'messageModel' => $messageModel, 'model' => $model]
        );
    }

    /**
     * @return array|bool[]
     */
    public function actionAddMessage()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $messageModel = new Message();
        $model = new AddMessageForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $messageModel->text = $model->message;
            if ($messageModel->save()) {
                return ['success' => true];
            }
        }

        return ['success' => false, 'errors' => $messageModel->errors,];
    }

    public function actionIncorrectMessage()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        if ($model = Message::findOne((int)$id)) {
            $model->is_incorrect = Message::MESSAGE_INCORRECT;
            if ($model->save()) {
                return ['success' => true];
            }
        }

        return ['success' => false, 'errors' => $model->errors ?? []];
    }
}
