<?php

namespace backend\models;

use Yii;

class ProjectFile extends \yii\db\ActiveRecord{
    
    public static function tableName(){
        return 'project_file';
    }

    public function rules(){
        return [
            [['IdProject', 'FIle'], 'required'],
            [['IdProject'], 'integer'],
            [['FIle'], 'string', 'max' => 255],
            [['IdProject'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['IdProject' => 'Id']],
        ];
    }

    public function attributeLabels(){
        return [
            'Id' => 'ID',
            'IdProject' => 'Id Project',
            'FIle' => 'F Ile',
        ];
    }

    public function getIdProject__r(){
        return $this->hasOne(Project::className(), ['Id' => 'IdProject']);
    }
}
