<?php

namespace backend\models;

use Yii;

class SupplierContact extends \yii\db\ActiveRecord{
    
    public static function tableName(){
        return 'supplier_contact';
    }

    public function rules(){
        return [
            [['IdSupplier'], 'required'],
            [['IdSupplier'], 'integer'],
            [['Name'], 'string', 'max' => 100],
            [['Phone'], 'string', 'max' => 25],
            [['IdSupplier'], 'exist', 'skipOnError' => true, 'targetClass' => Supplier::className(), 'targetAttribute' => ['IdSupplier' => 'Id']],
        ];
    }

    public function attributeLabels(){
        return [
            'Id' => 'ID',
            'IdSupplier' => 'Id Supplier',
            'Name' => 'Name',
            'Phone' => 'Phone',
        ];
    }

    public function getIdSupplier__r(){
        return $this->hasOne(Supplier::className(), ['Id' => 'IdSupplier']);
    }
}
