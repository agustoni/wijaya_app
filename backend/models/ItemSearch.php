<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Item;

/**
 * ItemSearch represents the model behind the search form of `backend\models\Item`.
 */
class ItemSearch extends Item
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['Id', 'IdUoM', 'Type'], 'integer'],
            [['IdUoM', 'Name', 'Description', 'Type'], 'safe'],
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
        $query = Item::find()
                        ->joinWith(['itemUnit__r']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'Id' => $this->Id,
            // 'IdUoM' => $this->IdUoM,
            'Type' => $this->Type,
        ]);

        $query->andFilterWhere(['like', 'Name', $this->Name])
            ->andFilterWhere(['like', 'item_unit.UoM', $this->IdUoM])
            ->andFilterWhere(['like', 'Description', $this->Description]);

        return $dataProvider;
    }
}
