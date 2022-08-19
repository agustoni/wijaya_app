<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Project;

/**
 * ProjectSearch represents the model behind the search form of `backend\models\Project`.
 */
class ProjectSearch extends Project
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Id', 'PI_By', 'DP_By', 'QC_By', 'BAST_By', 'Status', 'UpdatePermission', 'Duration', 'CreatedBy'], 'integer'],
            [['NoProject', 'ProjectAt', 'Name', 'PaymentTerm', 'PI_At', 'DP_At', 'QC_At', 'BAST_At', 'StartDate', 'EndDate', 'CreatedAt'], 'safe'],
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
        $query = Project::find();

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
            'Id' => $this->Id,
            'ProjectAt' => $this->ProjectAt,
            'PI_At' => $this->PI_At,
            'PI_By' => $this->PI_By,
            'DP_At' => $this->DP_At,
            'DP_By' => $this->DP_By,
            'QC_At' => $this->QC_At,
            'QC_By' => $this->QC_By,
            'BAST_At' => $this->BAST_At,
            'BAST_By' => $this->BAST_By,
            'Status' => $this->Status,
            'UpdatePermission' => $this->UpdatePermission,
            'StartDate' => $this->StartDate,
            'EndDate' => $this->EndDate,
            'Duration' => $this->Duration,
            'CreatedAt' => $this->CreatedAt,
            'CreatedBy' => $this->CreatedBy,
        ]);

        $query->andFilterWhere(['like', 'NoProject', $this->NoProject])
            ->andFilterWhere(['like', 'Name', $this->Name])
            ->andFilterWhere(['like', 'PaymentTerm', $this->PaymentTerm]);

        return $dataProvider;
    }
}
