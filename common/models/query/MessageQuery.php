<?php

namespace common\models\query;

use common\models\Message;

/**
 * This is the ActiveQuery class for [[Message]].
 *
 * @see Message
 */
class MessageQuery extends \yii\db\ActiveQuery
{

    /**
     * {@inheritdoc}
     * @return Message[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Message|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return MessageQuery
     */
    public function onlyCorrectMessage(): MessageQuery
    {
        return $this->andWhere([Message::tableName() . '.[[is_incorrect]]' => Message::MESSAGE_CORRECT]);
    }

    /**
     * @return MessageQuery
     */
    public function onlyInCorrectMessage(): MessageQuery
    {
        return $this->andWhere([Message::tableName() . '.[[is_incorrect]]' => Message::MESSAGE_INCORRECT]);
    }
}
