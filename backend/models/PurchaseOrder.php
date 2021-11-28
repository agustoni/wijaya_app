<?php

namespace backend\models;

use Yii;

class PurchaseOrder extends \yii\db\ActiveRecord{
   
    public static function tableName(){
        return 'purchase_order';
    }

    public function rules(){
        return [
            [['Total', 'CreatedAt', 'CreatedBy'], 'required'],
            [['Total'], 'number'],
            [['ReceivedAt', 'CreatedAt'], 'safe'],
            [['ReceivedBy', 'CreatedBy', 'Status'], 'integer'],
            [['PoNumber'], 'string', 'max' => 50],
            [['CreatedBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['CreatedBy' => 'id']],
            [['ReceivedBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['ReceivedBy' => 'id']],
        ];
    }

    public function attributeLabels(){
        return [
            'Id' => 'ID',
            'PoNumber' => 'Po Number',
            'Total' => 'Total',
            'ReceivedAt' => 'Received At',
            'ReceivedBy' => 'Received By',
            'CreatedAt' => 'Created At',
            'CreatedBy' => 'Created By',
            'Status' => 'Status',
        ];
    }

    public function getCreatedBy__r(){
        return $this->hasOne(User::className(), ['id' => 'CreatedBy']);
    }

    public function getReceivedBy__r(){
        return $this->hasOne(User::className(), ['id' => 'ReceivedBy']);
    }
}
