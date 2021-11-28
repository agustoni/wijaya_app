<?php

namespace backend\models;

use Yii;

class ProjectPayment extends \yii\db\ActiveRecord{
    
    public static function tableName(){
        return 'project_payment';
    }

    public function rules(){
        return [
            [['IdProject', 'DueDate'], 'required'],
            [['IdProject', 'PayoutPhase', 'InvoiceBy', 'ProgressCheckBy', 'Status'], 'integer'],
            [['PaymentDate', 'DueDate', 'InvoiceAt', 'ProgressCheckAt'], 'safe'],
            [['InvoiceBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['InvoiceBy' => 'id']],
            [['IdProject'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['IdProject' => 'Id']],
        ];
    }

    public function attributeLabels(){
        return [
            'Id' => 'ID',
            'IdProject' => 'Id Project',
            'PayoutPhase' => 'Payout Phase',
            'PaymentDate' => 'Payment Date',
            'DueDate' => 'Due Date',
            'InvoiceAt' => 'Invoice At',
            'InvoiceBy' => 'Invoice By',
            'ProgressCheckAt' => 'Progress Check At',
            'ProgressCheckBy' => 'Progress Check By',
            'Status' => 'Status',
        ];
    }

    public function getInvoiceBy__r(){
        return $this->hasOne(User::className(), ['id' => 'InvoiceBy']);
    }

    public function getIdProject__r(){
        return $this->hasOne(Project::className(), ['Id' => 'IdProject']);
    }
}
