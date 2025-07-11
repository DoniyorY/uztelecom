<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AttendanceRecords;

/**
 * AttendanceRecordsSearch represents the model behind the search form of `common\models\AttendanceRecords`.
 */
class AttendanceRecordsSearch extends AttendanceRecords
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'employee_id', 'status', 'time_in', 'time_out', 'source', 'created_at', 'updated_at'], 'integer'],
            [['date', 'comment'], 'safe'],
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
        $query = AttendanceRecords::find();

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
            'employee_id' => $this->employee_id,
            'date' => $this->date,
            'status' => $this->status,
            'time_in' => $this->time_in,
            'time_out' => $this->time_out,
            'source' => $this->source,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
