<?php

namespace backend\models;

use Yii;

class ProjectContact extends \yii\db\ActiveRecord{
    
    public static function tableName(){
        return 'project_contact';
    }

    public function rules(){
        return [
            [['IdProjectClient'], 'required'],
            [['IdProjectClient'], 'integer'],
            [['Name', 'Title', 'Role'], 'string', 'max' => 50],
            [['Email'], 'string', 'max' => 100],
            [['Phone'], 'string', 'max' => 25],
            [['IdProjectClient'], 'exist', 'skipOnError' => true, 'targetClass' => ProjectClient::className(), 'targetAttribute' => ['IdProjectClient' => 'Id']],
        ];
    }

    public function attributeLabels(){
        return [
            'Id' => 'ID',
            'IdProjectClient' => 'Id Project Client',
            'Name' => 'Name',
            'Title' => 'Jabatan',
            'Role' => 'Role',
            'Phone' => 'Phone',
            'Email' => 'Email',
        ];
    }

    public function getIdProjectClient__r(){
        return $this->hasOne(ProjectClient::className(), ['Id' => 'IdProjectClient']);
    }
}
