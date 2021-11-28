<?php

namespace backend\models;

use Yii;

class ItemPart extends \yii\db\ActiveRecord{
    
    public static function tableName(){
        return 'item_part';
    }

    public function rules(){
        return [
            [['IdParentItem', 'IdItem'], 'integer'],
            [['IdItem'], 'required'],
            [['IdItem'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['IdItem' => 'Id']],
            [['IdParentItem'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['IdParentItem' => 'Id']],
        ];
    }

    public function attributeLabels(){
        return [
            'Id' => 'ID',
            'IdParentItem' => 'Id Parent Item',
            'IdItem' => 'Id Item',
        ];
    }

    public function getItem__r(){
        return $this->hasOne(Item::className(), ['Id' => 'IdItem']);
    }

    public function getParentItem__r(){
        return $this->hasOne(Item::className(), ['Id' => 'IdParentItem']);
    }
}
