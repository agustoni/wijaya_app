<?php

namespace backend\models;

use Yii;

class ProductionRequest extends \yii\db\ActiveRecord{
    
    public static function tableName(){
        return 'production_request';
    }

    public function rules(){
        return [
            [['RequestAt', 'ReceivedAt'], 'safe'],
            [['RequestBy', 'ReceivedBy'], 'integer'],
            [['NoRequest'], 'string', 'max' => 25],
            [['ReceivedBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['ReceivedBy' => 'id']],
            [['RequestBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['RequestBy' => 'id']],
        ];
    }

    public function attributeLabels(){
        return [
            'Id' => 'ID',
            'NoRequest' => 'No Request',
            'RequestAt' => 'Request At',
            'RequestBy' => 'Request By',
            'ReceivedAt' => 'Received At',
            'ReceivedBy' => 'Received By',
        ];
    }

    public function getReceivedBy__r(){
        return $this->hasOne(User::className(), ['id' => 'ReceivedBy']);
    }

    public function getRequestBy__r(){
        return $this->hasOne(User::className(), ['id' => 'RequestBy']);
    }

    public function getProductionRequestItem__r(){
        return $this->hasMany(ProductionRequestItem::className(), ['IdRequest' => 'Id']);
    }
}
