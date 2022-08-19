<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PurchaseOrder;

/**
 * PurchaseOrderSearch represents the model behind the search form of `backend\models\PurchaseOrder`.
 */
class PurchaseOrderSearch extends PurchaseOrder
{
    public function rules()
    {
        return [
            [['Id', 'ReceivedAt', 'ReceivedBy', 'ApprovedAt', 'ApprovedBy', 'CanceledAt', 'CanceledBy', 'CreatedBy', 'Status'], 'integer'],
            [['PoNumber', 'CreatedAt', 'IdSupplier'], 'safe'],
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
    public function search($params, $_from, $_to)
    {
        $query = PurchaseOrder::find()
                    ->joinWith(['supplier__r'])
                    ->where('Status != 0 AND CreatedAt >= "'.date('Y-m-d', strtotime($_from)).' 00:00:00'.'" AND CreatedAt <= "'.date('Y-m-d', strtotime($_to)).' 23:59:59'.'"');

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

        if($this->ReceivedAt != ''){
            if($this->ReceivedAt == 0){
                $query->andWhere(['is', 'purchase_order.ReceivedAt', new \yii\db\Expression('null')]);
            }else{
                $query->andWhere(['not', ['purchase_order.ReceivedAt'=> null]]);
            }
        }

        if($this->ApprovedAt != ''){
            if($this->ApprovedAt == 0){
                $query->andWhere(['is', 'purchase_order.ApprovedAt', new \yii\db\Expression('null')]);
            }else{
                $query->andWhere(['not', ['purchase_order.ApprovedAt'=> null]]);
            }
        }

        $query->andFilterWhere(['like', 'supplier.Name', $this->IdSupplier])
              ->andFilterWhere(['like', 'purchase_order.PoNumber', $this->PoNumber]);

        // grid filtering conditions
        $query->andFilterWhere([
            // 'Id' => $this->Id,
            // 'IdSupplier' => $this->IdSupplier,
            'Total' => $this->Total,
            // 'ReceivedAt' => $this->ReceivedAt,
            // 'ReceivedBy' => $this->ReceivedBy,
            // 'ApprovedAt' => $this->ApprovedAt,
            // 'ApprovedBy' => $this->ApprovedBy,
            'CanceledAt' => $this->CanceledAt,
            'CanceledBy' => $this->CanceledBy,
            'CreatedAt' => $this->CreatedAt,
            'CreatedBy' => $this->CreatedBy,
            'Status' => $this->Status,
        ]);

        $query->andFilterWhere(['like', 'PoNumber', $this->PoNumber]);

        return $dataProvider;
    }
}
