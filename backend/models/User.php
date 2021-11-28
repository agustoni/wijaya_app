<?php

namespace backend\models;

use Yii;

class User extends \yii\db\ActiveRecord{
    
    public static function tableName(){
        return 'user';
    }

    public function rules(){
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    public function attributeLabels(){
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'verification_token' => 'Verification Token',
        ];
    }

    public function getProReqReceivedBy__r(){
        return $this->hasMany(ProductionRequest::className(), ['ReceivedBy' => 'id']);
    }

    public function getProReqRequestBy__r(){
        return $this->hasMany(ProductionRequest::className(), ['RequestBy' => 'id']);
    }

    public function getProReqItemReceivedBy__r(){
        return $this->hasMany(ProductionRequestItem::className(), ['ReceivedBy' => 'id']);
    }

    public function getProjectBASTBy__r(){
        return $this->hasMany(Project::className(), ['BAST_By' => 'id']);
    }

    public function getProjectCreatedBy__r(){
        return $this->hasMany(Project::className(), ['CreatedBy' => 'id']);
    }

    public function getProjectDPBy__r(){
        return $this->hasMany(Project::className(), ['DP_By' => 'id']);
    }

    public function getProjectPIBy__r(){
        return $this->hasMany(Project::className(), ['PI_By' => 'id']);
    }

    public function getProjectQCBy__r(){
        return $this->hasMany(Project::className(), ['QC_By' => 'id']);
    }

    public function getProjectItemReceivedBy__r(){
        return $this->hasMany(ProjectItem::className(), ['ReceivedBy' => 'id']);
    }

    public function getProjectLogCreatedBy__r(){
        return $this->hasMany(ProjectLog::className(), ['CreatedBy' => 'id']);
    }

    public function getProjectNoteCreatedBy__r){
        return $this->hasMany(ProjectNote::className(), ['CreatedBy' => 'id']);
    }

    public function getProjectPaymentInvoiceBy__r(){
        return $this->hasMany(ProjectPayment::className(), ['InvoiceBy' => 'id']);
    }

    public function getProjectWorker__r(){
        return $this->hasMany(ProjectWorker::className(), ['IdWorker' => 'id']);
    }

    public function getPurchaseOrderCreatedBy__r(){
        return $this->hasMany(PurchaseOrder::className(), ['CreatedBy' => 'id']);
    }

    public function getPurchaseOrderReceivedBy__r(){
        return $this->hasMany(PurchaseOrder::className(), ['ReceivedBy' => 'id']);
    }

    public function getQuotationApprovedBy__r(){
        return $this->hasMany(Quotation::className(), ['ApprovedBy' => 'id']);
    }
}
