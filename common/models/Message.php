<?php

namespace common\models;

use common\behaviors\CreatedByBehavior;
use common\models\query\MessageQuery;
use DateTime;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "message".
 *
 * @property int         $id
 * @property string      $text         Текст сообщения
 * @property int         $is_incorrect Признак некорректного сообщения
 * @property int|null    $created_by   Id пользователя
 * @property string|null $created_at   Дата создания
 * @property string|null $updated_at   Дата изменения
 *
 * @property User        $userRelation
 */
class Message extends ActiveRecord
{
    const MESSAGE_INCORRECT = 1;
    const MESSAGE_CORRECT = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'required'],
            [['text'], 'string'],
            [['is_incorrect', 'created_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [
                ['created_by'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => User::class,
                'targetAttribute' => ['created_by' => 'id'],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'           => 'ID',
            'text'         => 'Текст сообщения',
            'is_incorrect' => 'Признак некорректного сообщения',
            'created_by'   => 'Пользователь',
            'created_at'   => 'Дата создания',
            'updated_at'   => 'Дата изменения',
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'CreatedByBehavior' => CreatedByBehavior::class,
            'TimestampBehavior' => [
                'class' => TimestampBehavior::class,
                'value' => (new DateTime())->format('Y-m-d H:i:s'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     * @return MessageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MessageQuery(get_called_class());
    }

    /**
     * @return ActiveQuery
     */
    public function getUserRelation()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return ArrayHelper::getValue(static::getMessageStatus(), $this->is_incorrect);
    }

    public static function getMessageStatus()
    {
        return [
            Message::MESSAGE_INCORRECT => 'Некорректное',
            Message::MESSAGE_CORRECT   => 'Корректное',
        ];
    }
}
