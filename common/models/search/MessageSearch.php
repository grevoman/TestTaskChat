<?php

namespace common\models\search;

use common\models\Message;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MessageSearch represents the model behind the search form of `common\models\Message`.
 */
class MessageSearch extends Message
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'is_incorrect', 'created_by'], 'integer'],
            [['text', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * @param $params
     *
     * @return \common\models\query\MessageQuery
     */
    public function searchQuery($params)
    {
        $query = Message::find()->orderBy(['created_at' => SORT_DESC]);

        if (!Yii::$app->user->can('manageMessage')) {
            $query->andWhere(['is_incorrect' => Message::MESSAGE_CORRECT]);
        }

        $this->load($params);

        if (!$this->validate()) {
            return $$query;
        }

        // grid filtering conditions
        $query->andFilterWhere(
            [
                'id'           => $this->id,
                'is_incorrect' => $this->is_incorrect,
                'created_by'   => $this->created_by,
                'created_at'   => $this->created_at,
                'updated_at'   => $this->updated_at,
            ]
        );

        $query->andFilterWhere(['like', 'text', $this->text]);

        return $query;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        return new ActiveDataProvider(
            [
                'query' => $this->searchQuery($params),
            ]
        );
    }
}
