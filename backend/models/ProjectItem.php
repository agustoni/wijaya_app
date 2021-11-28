<?php

namespace backend\models;

use Yii;

class ProjectItem extends \yii\db\ActiveRecord{
    
    public static function tableName(){
        return 'project_item';
    }

    public function rules(){
        return [
            [['IdProject', 'IdItem', 'IdSupplier', 'Cost', 'Qty', 'Total'], 'required'],
            [['IdProject', 'IdItem', 'IdSupplier', 'PO', 'ReceivedBy', 'Status'], 'integer'],
            [['Cost', 'Qty', 'Total'], 'number'],
            [['ReceivedAt'], 'safe'],
            [['IdItem'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['IdItem' => 'Id']],
            [['IdProject'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['IdProject' => 'Id']],
            [['ReceivedBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['ReceiveBy' => 'id']],
            [['IdSupplier'], 'exist', 'skipOnError' => true, 'targetClass' => Supplier::className(), 'targetAttribute' => ['IdSupplier' => 'Id']],
        ];
    }

    public function attributeLabels(){
        return [
            'Id' => 'ID',
            'IdProject' => 'Id Project',
            'IdItem' => 'Id Item',
            'IdSupplier' => 'Id Supplier',
            'Cost' => 'Cost',
            'Qty' => 'Qty',
            'Total' => 'Total',
            'PO' => 'Po',
            'ReceivedAt' => 'Received At',
            'ReceivedBy' => 'Receive By',
            'Status' => 'Status',
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

    public function getIdSupplier__r(){
        return $this->hasOne(Supplier::className(), ['Id' => 'IdSupplier']);
    }
}
