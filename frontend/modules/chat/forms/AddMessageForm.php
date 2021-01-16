<?php

namespace app\modules\chat\forms;

use yii\base\Model;

class AddMessageForm extends Model
{
    /**
     * @var string
     */
    public $message;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['message', 'required'],
            ['message', 'string', 'length' => [1, 150]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'message' => 'Добавить сообщение:',
        ];
    }

}