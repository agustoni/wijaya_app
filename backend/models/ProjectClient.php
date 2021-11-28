<?php

namespace backend\models;

use Yii;

class ProjectClient extends \yii\db\ActiveRecord{
    
    public static function tableName(){
        return 'project_client';
    }

    public function rules(){
        return [
            [['IdProject'], 'required'],
            [['IdProject'], 'integer'],
            [['Address'], 'string'],
            [['Company'], 'string', 'max' => 255],
            // [['PIC'], 'string', 'max' => 150],
            // [['Phone'], 'string', 'max' => 50],
            // [['Email'], 'string', 'max' => 100],
            [['IdProject'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['IdProject' => 'Id']],
        ];
    }

    public function attributeLabels(){
        return [
            'Id' => 'ID',
            'IdProject' => 'No Project',
            'Company' => 'Perusahaan',
            // 'PIC' => 'Pic',
            // 'Phone' => 'Phone',
            'Address' => 'Address',
            // 'Email' => 'Email',
        ];
    }

    public function getIdProject__r(){
        return $this->hasOne(Project::className(), ['Id' => 'IdProject']);
    }

    public function getProjectContact__r(){
        return $this->hasMany(ProjectContact::className(), ['IdProjectClient' => 'Id']);
    }
}
