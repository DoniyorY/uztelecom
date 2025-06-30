<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RegistryDocument;

/**
 * RegistryDocumentSearch represents the model behind the search form of `common\models\RegistryDocument`.
 */
class RegistryDocumentSearch extends RegistryDocument
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'created_at', 'by_user_id', 'user_id'], 'integer'],
            [['token', 'doc_number', 'doc_content', 'doc_date', 'file'], 'safe'],
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
        $query = RegistryDocument::find();

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
            'company_id' => $this->company_id,
            'created_at' => $this->created_at,
            'by_user_id' => $this->by_user_id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'doc_number', $this->doc_number])
            ->andFilterWhere(['like', 'doc_content', $this->doc_content])
            ->andFilterWhere(['like', 'doc_date', $this->doc_date])
            ->andFilterWhere(['like', 'file', $this->file]);

        return $dataProvider;
    }
}
