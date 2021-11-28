<?php

namespace backend\models;

use Yii;

class SupplierItem extends \yii\db\ActiveRecord{
    
    public static function tableName(){
        return 'supplier_item';
    }

    public function rules(){
        return [
            [['IdSupplier', 'IdItem'], 'required'],
            [['IdSupplier', 'IdItem'], 'integer'],
            [['IdItem'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['IdItem' => 'Id']],
            [['IdSupplier'], 'exist', 'skipOnError' => true, 'targetClass' => Supplier::className(), 'targetAttribute' => ['IdSupplier' => 'Id']],
        ];
    }

    public function attributeLabels(){
        return [
            'Id' => 'ID',
            'IdSupplier' => 'Id Supplier',
            'IdItem' => 'Id Item',
        ];
    }

    public function getItem__r(){
        return $this->hasOne(Item::className(), ['Id' => 'IdItem']);
    }

    public function getIdSupplier__r(){
        return $this->hasOne(Supplier::className(), ['Id' => 'IdSupplier']);
    }

    public function getSupplierItemCost__r(){
        return $this->hasMany(SupplierItemCost::className(), ['IdSupplierItem' => 'Id']);
    }
}
