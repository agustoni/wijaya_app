<?php

namespace backend\models;

use Yii;

class SupplierItemCost extends \yii\db\ActiveRecord{
    
    public static function tableName(){
        return 'supplier_item_cost';
    }

    public function rules(){
        return [
            [['IdSupplier', 'Price', 'Qty'], 'required'],
            [['IdSupplier', 'Flag'], 'integer'],
            [['Price', 'Qty'], 'number'],
            [['IdSupplier'], 'exist', 'skipOnError' => true, 'targetClass' => Supplier::className(), 'targetAttribute' => ['IdSupplier' => 'Id']],
        ];
    }

    public function attributeLabels(){
        return [
            'Id' => 'ID',
            'IdSupplier' => 'Id Supplier',
            'Price' => 'Price',
            'Qty' => 'Qty',
            'Flag' => 'Flag',
        ];
    }

    public function getSupplierItem__r(){
        return $this->hasOne(SupplierItem::className(), ['Id' => 'IdSupplierItem']);
    }
}
