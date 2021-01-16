<?php

namespace common\behaviors;

use yii\base\Event;
use yii\base\InvalidConfigException;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\di\Instance;
use yii\web\User;

class CreatedByBehavior extends AttributeBehavior
{
    /**
     * @var string
     */
    public $user = 'user';

    /**
     * @var string
     */
    public $attribute = 'created_by';

    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [
                ActiveRecord::EVENT_BEFORE_INSERT => [$this->attribute],
            ];
        }
    }

    /**
     * @param Event $event
     *
     * @return int|mixed|string
     */
    protected function getValue($event)
    {
        try {
            /** @var User $user */
            $user = Instance::ensure($this->user, User::class);

            $id = $user->getId();
        } catch (InvalidConfigException $e) {
            $id = null;
        }

        return is_callable($this->value) ? call_user_func($this->value, $event) : $id;
    }
}