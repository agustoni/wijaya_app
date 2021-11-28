<?php

namespace backend\models;

use Yii;

class QuotationItem extends \yii\db\ActiveRecord{
    
    public static function tableName(){
        return 'quotation_item';
    }

    public function rules(){
        return [
            [['IdQuotation', 'IdItem', 'IdSupplier', 'Cost', 'Qty', 'Total'], 'required'],
            [['IdQuotation', 'IdItem', 'IdSupplier'], 'integer'],
            [['Cost', 'Qty', 'Total'], 'number'],
            [['Note'], 'string'],
            [['IdItem'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['IdItem' => 'Id']],
            [['IdQuotation'], 'exist', 'skipOnError' => true, 'targetClass' => Quotation::className(), 'targetAttribute' => ['IdQuotation' => 'Id']],
            [['IdSupplier'], 'exist', 'skipOnError' => true, 'targetClass' => Supplier::className(), 'targetAttribute' => ['IdSupplier' => 'Id']],
        ];
    }

    public function attributeLabels(){
        return [
            'Id' => 'ID',
            'IdQuotation' => 'Id Quotation',
            'IdItem' => 'Id Item',
            'IdSupplier' => 'Id Supplier',
            'Cost' => 'Cost',
            'Qty' => 'Qty',
            'Total' => 'Total',
            'Note' => 'Note',
        ];
    }

    public function getIdItem__r(){
        return $this->hasOne(Item::className(), ['Id' => 'IdItem']);
    }

    public function getIdQuotation__r(){
        return $this->hasOne(Quotation::className(), ['Id' => 'IdQuotation']);
    }

    public function getIdSupplier__r(){
        return $this->hasOne(Supplier::className(), ['Id' => 'IdSupplier']);
    }
}
