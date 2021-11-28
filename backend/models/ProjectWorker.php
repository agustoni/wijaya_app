<?php

namespace backend\models;

use Yii;

class ProjectWorker extends \yii\db\ActiveRecord{
    
    public static function tableName(){
        return 'project_worker';
    }

    public function rules(){
        return [
            [['IdProject', 'IdWorker', 'StartDate'], 'required'],
            [['IdProject', 'IdWorker'], 'integer'],
            [['StartDate'], 'safe'],
            [['IdProject'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['IdProject' => 'Id']],
            [['IdWorker'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['IdWorker' => 'id']],
        ];
    }

    public function attributeLabels(){
        return [
            'Id' => 'ID',
            'IdProject' => 'Id Project',
            'IdWorker' => 'Id Worker',
            'StartDate' => 'Start Date',
        ];
    }

    public function getIdProject__r(){
        return $this->hasOne(Project::className(), ['Id' => 'IdProject']);
    }

    public function getIdWorker__r(){
        return $this->hasOne(User::className(), ['id' => 'IdWorker']);
    }
}
