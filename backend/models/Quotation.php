<?php

namespace backend\models;

use Yii;

class Quotation extends \yii\db\ActiveRecord{
    
    public static function tableName(){
        return 'quotation';
    }

    public function rules(){
        return [
            [['IdProject', 'ExpiredDate', 'CreatedAt', 'CreatedBy', 'Status'], 'required'],
            [['IdProject', 'CreatedBy', 'ApprovedBy', 'Status'], 'integer'],
            [['ExpiredDate', 'SentAt', 'CreatedAt', 'ApprovedAt'], 'safe'],
            [['IdProject'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['IdProject' => 'Id']],
            [['ApprovedBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['ApprovedBy' => 'id']],
        ];
    }

    public function attributeLabels(){
        return [
            'Id' => 'ID',
            'IdProject' => 'Id Project',
            'ExpiredDate' => 'Expired Date',
            'SentAt' => 'Sent At',
            'CreatedAt' => 'Created At',
            'CreatedBy' => 'Created By',
            'ApprovedAt' => 'Approved At',
            'ApprovedBy' => 'Approved By',
            'Status' => 'Status',
        ];
    }

    public function getIdProject__r(){
        return $this->hasOne(Project::className(), ['Id' => 'IdProject']);
    }

    public function getApprovedBy__r(){
        return $this->hasOne(User::className(), ['id' => 'ApprovedBy']);
    }

    public function getQuotationItem__r(){
        return $this->hasMany(QuotationItem::className(), ['IdQuotation' => 'Id']);
    }
}
