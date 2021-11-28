<?php

namespace backend\models;

use Yii;

class ProjectType extends \yii\db\ActiveRecord{
    
    public static function tableName(){
        return 'project_type';
    }

    public function rules(){
        return [
            [['Type', 'JsonForm'], 'required'],
            [['JsonForm'], 'string'],
            [['Type'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels(){
        return [
            'Id' => 'ID',
            'Type' => 'Type',
            'JsonForm' => 'Json Form',
        ];
    }

    public function getProjectDetail__r(){
        return $this->hasMany(ProjectDetail::className(), ['IdProjectType' => 'Id']);
    }
}
