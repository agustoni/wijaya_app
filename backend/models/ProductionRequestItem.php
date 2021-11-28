<?php

namespace backend\models;

use Yii;

class ProductionRequestItem extends \yii\db\ActiveRecord{
    
    public static function tableName(){
        return 'production_request_item';
    }

    public function rules(){
        return [
            [['IdRequest', 'IdItem', 'IdSupplier', 'Cost', 'Qty', 'Total'], 'required'],
            [['IdRequest', 'IdItem', 'IdSupplier', 'PO', 'ReceivedBy', 'IdProject'], 'integer'],
            [['Cost', 'Qty', 'Total'], 'number'],
            [['ReceivedAt'], 'safe'],
            [['IdItem'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['IdItem' => 'Id']],
            [['IdProject'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['IdProject' => 'Id']],
            [['ReceivedBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['ReceivedBy' => 'id']],
            [['IdRequest'], 'exist', 'skipOnError' => true, 'targetClass' => ProductionRequest::className(), 'targetAttribute' => ['IdRequest' => 'Id']],
            [['IdSupplier'], 'exist', 'skipOnError' => true, 'targetClass' => Supplier::className(), 'targetAttribute' => ['IdSupplier' => 'Id']],
        ];
    }

    public function attributeLabels(){
        return [
            'Id' => 'ID',
            'IdRequest' => 'Id Request',
            'IdItem' => 'Id Item',
            'IdSupplier' => 'Id Supplier',
            'Cost' => 'Cost',
            'Qty' => 'Qty',
            'Total' => 'Total',
            'PO' => 'Po',
            'ReceivedAt' => 'Received At',
            'ReceivedBy' => 'Received By',
            'IdProject' => 'Id Project',
        ];
    }

    public function getIdItem__r(){
        return $this->hasOne(Item::className(), ['Id' => 'IdItem']);
    }

    public function getIdProject__r(){
        return $this->hasOne(Project::className(), ['Id' => 'IdProject']);
    }

    public function getReceivedBy__r(){
        return $this->hasOne(User::className(), ['id' => 'ReceivedBy']);
    }

    public function getIdRequest__r(){
        return $this->hasOne(ProductionRequest::className(), ['Id' => 'IdRequest']);
    }

    public function getIdSupplier__r(){
        return $this->hasOne(Supplier::className(), ['Id' => 'IdSupplier']);
    }
}
