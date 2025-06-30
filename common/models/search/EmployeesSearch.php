<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Employees;

/**
 * EmployeesSearch represents the model behind the search form of `common\models\Employees`.
 */
class EmployeesSearch extends Employees
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sex', 'birthday', 'nationality', 'family_status', 'passport_end_date', 'citizenship', 'birthday_city', 'postcode', 'tra_start_date', 'tra_end_date', 'created', 'updated', 'status'], 'integer'],
            [['fullname', 'passport_series', 'passport_pinfl', 'passport_inn', 'passport_whois', 'mobile_phone', 'work_phone', 'city', 'area', 'address', 'address_registration', 'temporary_registration_address', 'image'], 'safe'],
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
        $query = Employees::find();

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
            'sex' => $this->sex,
            'birthday' => $this->birthday,
            'nationality' => $this->nationality,
            'family_status' => $this->family_status,
            'passport_end_date' => $this->passport_end_date,
            'citizenship' => $this->citizenship,
            'birthday_city' => $this->birthday_city,
            'postcode' => $this->postcode,
            'tra_start_date' => $this->tra_start_date,
            'tra_end_date' => $this->tra_end_date,
            'created' => $this->created,
            'updated' => $this->updated,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'fullname', $this->fullname])
            ->andFilterWhere(['like', 'passport_series', $this->passport_series])
            ->andFilterWhere(['like', 'passport_pinfl', $this->passport_pinfl])
            ->andFilterWhere(['like', 'passport_inn', $this->passport_inn])
            ->andFilterWhere(['like', 'passport_whois', $this->passport_whois])
            ->andFilterWhere(['like', 'mobile_phone', $this->mobile_phone])
            ->andFilterWhere(['like', 'work_phone', $this->work_phone])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'area', $this->area])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'address_registration', $this->address_registration])
            ->andFilterWhere(['like', 'temporary_registration_address', $this->temporary_registration_address])
            ->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }
}
