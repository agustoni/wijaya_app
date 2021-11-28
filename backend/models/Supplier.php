<?php

namespace backend\models;

use Yii;

class Supplier extends \yii\db\ActiveRecord{
    
    public static function tableName(){
        return 'supplier';
    }

    public function rules(){
        return [
            [['Address'], 'string'],
            [['Name'], 'string', 'max' => 150],
            [['Phone'], 'string', 'max' => 25],
        ];
    }

    public function attributeLabels(){
        return [
            'Id' => 'ID',
            'Name' => 'Name',
            'Address' => 'Address',
            'Phone' => 'Phone',
        ];
    }

    public function getProReqItem__r(){
        return $this->hasMany(ProductionRequestItem::className(), ['IdSupplier' => 'Id']);
    }

    public function getProjectItem__r(){
        return $this->hasMany(ProjectItem::className(), ['IdSupplier' => 'Id']);
    }

    public function getQuotationItem__r(){
        return $this->hasMany(QuotationItem::className(), ['IdSupplier' => 'Id']);
    }

    public function getSupplierContact__r(){
        return $this->hasMany(SupplierContact::className(), ['IdSupplier' => 'Id']);
    }

    public function getSupplierItem__r(){
        return $this->hasMany(SupplierItem::className(), ['IdSupplier' => 'Id']);
    }

    public function getSupplierItemCost__r(){
        return $this->hasMany(SupplierItemCost::className(), ['IdSupplierItem' => 'Id']);
    }
}
