<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserWork;

/**
 * UserWorkSearch represents the model behind the search form of `common\models\UserWork`.
 */
class UserWorkSearch extends UserWork
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'company_id', 'department_id', 'position_id', 'updated_at', 'salary', 'one_hour'], 'integer'],
            [['bid'], 'number'],
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = UserWork::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'company_id' => $this->company_id,
            'department_id' => $this->department_id,
            'position_id' => $this->position_id,
            'updated_at' => $this->updated_at,
            'salary' => $this->salary,
            'one_hour' => $this->one_hour,
            'bid' => $this->bid,
        ]);

        return $dataProvider;
    }
}
