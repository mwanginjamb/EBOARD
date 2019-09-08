<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Calendar;

/**
 * CalendarSearch represents the model behind the search form of `frontend\models\Calendar`.
 */
class CalendarSearch extends Calendar
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['event', 'scheduled_date', 'start_time', 'end_time', 'venue', 'created_at', 'updated_at', 'creator', 'creatorDesignation'], 'safe'],
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Calendar::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'scheduled_date' => $this->scheduled_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'event', $this->event])
            ->andFilterWhere(['like', 'venue', $this->venue])
            ->andFilterWhere(['like', 'creator', $this->creator])
            ->andFilterWhere(['like', 'creatorDesignation', $this->creatorDesignation]);

        return $dataProvider;
    }
}
