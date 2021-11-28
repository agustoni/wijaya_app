<?php

namespace backend\models;

use Yii;

class ProjectDetail extends \yii\db\ActiveRecord{
    
    public static function tableName(){
        return 'project_detail';
    }

    public function rules(){
        return [
            [['IdProject', 'IdProjectType'], 'required'],
            [['IdProject', 'IdProjectType'], 'integer'],
            [['Detail'], 'string'],
            [['IdProject'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['IdProject' => 'Id']],
            [['IdProjectType'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectType::className(), 'targetAttribute' => ['IdProjectType' => 'Id']],
        ];
    }

    public function attributeLabels(){
        return [
            'Id' => 'ID',
            'IdProject' => 'Id Project',
            'IdProjectType' => 'Id Project Type',
            'Detail' => 'Detail',
        ];
    }

    public function getIdProject__r(){
        return $this->hasOne(Project::className(), ['Id' => 'IdProject']);
    }

    public function getIdProjectType__r(){
        return $this->hasOne(ProjectType::className(), ['Id' => 'IdProjectType']);
    }
}
