<?php

namespace backend\models;

use Yii;

class ItemStock extends \yii\db\ActiveRecord{
   
    public static function tableName(){
        return 'item_stock';
    }

    public function rules(){
        return [
            [['IdItem', 'Stock'], 'required'],
            [['IdItem'], 'integer'],
            [['Stock'], 'number'],
            [['IdItem'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['IdItem' => 'Id']],
        ];
    }

    public function attributeLabels(){
        return [
            'Id' => 'ID',
            'IdItem' => 'Id Item',
            'Stock' => 'Stock',
        ];
    }

    public function getIdItem__r(){
        return $this->hasOne(Item::className(), ['Id' => 'IdItem']);
    }
}
