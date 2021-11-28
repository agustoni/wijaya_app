<?php

namespace backend\models;

use Yii;

class ProjectNote extends \yii\db\ActiveRecord{
    
    public static function tableName(){
        return 'project_note';
    }

    public function rules(){
        return [
            [['IdProject', 'CreatedAt', 'CreatedBy'], 'required'],
            [['IdProject', 'Hashtag', 'CreatedBy'], 'integer'],
            [['Description'], 'string'],
            [['CreatedAt'], 'safe'],
            [['CreatedBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['CreatedBy' => 'id']],
            [['IdProject'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['IdProject' => 'Id']],
        ];
    }

    public function attributeLabels(){
        return [
            'Id' => 'ID',
            'IdProject' => 'Id Project',
            'Description' => 'Description',
            'Hashtag' => 'Hashtag',
            'CreatedAt' => 'Created At',
            'CreatedBy' => 'Created By',
        ];
    }

    public function getCreatedBy__r(){
        return $this->hasOne(User::className(), ['id' => 'CreatedBy']);
    }

    public function getIdProject__r(){
        return $this->hasOne(Project::className(), ['Id' => 'IdProject']);
    }
}
