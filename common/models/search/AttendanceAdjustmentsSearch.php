<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AttendanceAdjustments;

/**
 * AttendanceAdjustmentsSearch represents the model behind the search form of `common\models\AttendanceAdjustments`.
 */
class AttendanceAdjustmentsSearch extends AttendanceAdjustments
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'attendance_id', 'old_status', 'new_status', 'user_id', 'changed_at'], 'integer'],
            [['reason'], 'safe'],
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
        $query = AttendanceAdjustments::find();

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
            'attendance_id' => $this->attendance_id,
            'old_status' => $this->old_status,
            'new_status' => $this->new_status,
            'user_id' => $this->user_id,
            'changed_at' => $this->changed_at,
        ]);

        $query->andFilterWhere(['like', 'reason', $this->reason]);

        return $dataProvider;
    }
}
