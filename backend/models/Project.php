<?php

namespace backend\models;

use Yii;

class Project extends \yii\db\ActiveRecord{
    
    public static function tableName(){
        return 'project';
    }

    public function rules(){
        return [
            [['Name', 'PaymentTerm', 'StartDate', 'EndDate', 'Duration', 'CreatedAt', 'CreatedBy'], 'required'],
            [['Name', 'PaymentTerm'], 'string'],
            [['PI_At', 'DP_At', 'QC_At', 'BAST_At', 'StartDate', 'EndDate', 'CreatedAt'], 'safe'],
            [['PI_By', 'DP_By', 'QC_By', 'BAST_By', 'Status', 'UpdatePermission', 'Duration', 'CreatedBy'], 'integer'],
            [['NoProject'], 'string', 'max' => 50],
            [['BAST_By'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['BAST_By' => 'id']],
            [['CreatedBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['CreatedBy' => 'id']],
            [['DP_By'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['DP_By' => 'id']],
            [['PI_By'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['PI_By' => 'id']],
            [['QC_By'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['QC_By' => 'id']],
        ];
    }

    public function attributeLabels(){
        return [
            'Id' => 'ID',
            'NoProject' => 'No Project',
            'Name' => 'Name',
            'PaymentTerm' => 'Payment Term',
            'PI_At' => 'Pi At',
            'PI_By' => 'Pi By',
            'DP_At' => 'Dp At',
            'DP_By' => 'Dp By',
            'QC_At' => 'Qc At',
            'QC_By' => 'Qc By',
            'BAST_At' => 'Bast At',
            'BAST_By' => 'Bast By',
            'Status' => 'Status',
            'UpdatePermission' => 'Update Permission',
            'StartDate' => 'Start Date',
            'EndDate' => 'End Date',
            'Duration' => 'Duration',
            'CreatedAt' => 'Created At',
            'CreatedBy' => 'Created By',
        ];
    }

    public function getProReqItem__r(){
        return $this->hasMany(ProductionRequestItem::className(), ['IdProject' => 'Id']);
    }

    public function getBASTBy__r(){
        return $this->hasOne(User::className(), ['id' => 'BAST_By']);
    }

    public function getCreatedBy__r(){
        return $this->hasOne(User::className(), ['id' => 'CreatedBy']);
    }

    public function getDPBy__r(){
        return $this->hasOne(User::className(), ['id' => 'DP_By']);
    }

    public function getPIBy__r(){
        return $this->hasOne(User::className(), ['id' => 'PI_By']);
    }

    public function getQCBy__r(){
        return $this->hasOne(User::className(), ['id' => 'QC_By']);
    }

    public function getProjectAmount__r(){
        return $this->hasMany(ProjectAmount::className(), ['IdProject' => 'Id']);
    }

    public function getProjectClient__r(){
        return $this->hasMany(ProjectClient::className(), ['IdProject' => 'Id']);
    }

    public function getProjectDetail__r(){
        return $this->hasMany(ProjectDetail::className(), ['IdProject' => 'Id']);
    }

    public function getProjectFile__r(){
        return $this->hasMany(ProjectFile::className(), ['IdProject' => 'Id']);
    }

    public function getProjectItem__r(){
        return $this->hasMany(ProjectItem::className(), ['IdProject' => 'Id']);
    }

    public function getProjectLog__r(){
        return $this->hasMany(ProjectLog::className(), ['IdProject' => 'Id']);
    }

    public function getProjectNote__r(){
        return $this->hasMany(ProjectNote::className(), ['IdProject' => 'Id']);
    }

    public function getProjectPayment__r(){
        return $this->hasMany(ProjectPayment::className(), ['IdProject' => 'Id']);
    }

    public function getProjectWorker__r(){
        return $this->hasMany(ProjectWorker::className(), ['IdProject' => 'Id']);
    }

    public function getQuotation__r(){
        return $this->hasMany(Quotation::className(), ['IdProject' => 'Id']);
    }
}
