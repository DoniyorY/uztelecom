<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DirectoryList;

/**
 * DirectoryListSearch represents the model behind the search form of `common\models\DirectoryList`.
 */
class DirectoryListSearch extends DirectoryList
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'class_id'], 'integer'],
            [['name_ru', 'name_uzkyrl', 'name_uzlat', 'type', 'class_name'], 'safe'],
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
        $query = DirectoryList::find();

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
            'category_id' => $this->category_id,
            'class_id' => $this->class_id,
        ]);

        $query->andFilterWhere(['like', 'name_ru', $this->name_ru])
            ->andFilterWhere(['like', 'name_uzkyrl', $this->name_uzkyrl])
            ->andFilterWhere(['like', 'name_uzlat', $this->name_uzlat])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'class_name', $this->class_name]);

        return $dataProvider;
    }
}
