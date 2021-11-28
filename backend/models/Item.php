<?php

namespace backend\models;

use Yii;

class Item extends \yii\db\ActiveRecord{
    // jenis item internal atau item project
    public $itemType = [
        1 => "Siap Pakai", 
        2 => "Kombinasi",
        3 => "Jasa",
        4 => "Part"
    ];
    
    public static function tableName(){
        return 'item';
    }

    public function rules(){
        return [
            [['Name', 'Type'], 'required'],
            [['Description'], 'string'],
            [['Type'], 'integer'],
            [['Name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels(){
        return [
            'Id' => 'ID',
            'Name' => 'Name',
            'Description' => 'Description',
            'Type' => 'Type',
            'IdUoM' => 'UoM'
        ];
    }

    public function getItemUnit__r(){
        return $this->hasOne(ItemUnit::className(), ['Id' => 'IdUoM']);
    }

    public function getItemPart__r(){
        return $this->hasMany(ItemPart::className(), ['IdItem' => 'Id']);
    }

    public function getItemPartParent__r(){
        return $this->hasMany(ItemPart::className(), ['IdParentItem' => 'Id']);
    }

    public function getItemStock__r(){
        return $this->hasMany(ItemStock::className(), ['IdItem' => 'Id']);
    }

    public function getProReqItem__r(){
        return $this->hasMany(ProductionRequestItem::className(), ['IdItem' => 'Id']);
    }

    public function getProjectItem__r(){
        return $this->hasMany(ProjectItem::className(), ['IdItem' => 'Id']);
    }

    public function getQuotationItem__r(){
        return $this->hasMany(QuotationItem::className(), ['IdItem' => 'Id']);
    }

    public function getSupplierItem__r(){
        return $this->hasMany(SupplierItem::className(), ['IdItem' => 'Id']);
    }
}
