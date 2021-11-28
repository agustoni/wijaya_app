<?php

namespace backend\models;

use Yii;

class projectLog extends \yii\db\ActiveRecord{
    
    public static function tableName(){
        return 'project_log';
    }

    public function rules(){
        return [
            [['IdProject', 'Description', 'CreatedAt', 'CreatedBy'], 'required'],
            [['IdProject', 'CreatedBy'], 'integer'],
            [['CreatedAt'], 'safe'],
            [['Description'], 'string', 'max' => 255],
            [['CreatedBy'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['CreatedBy' => 'id']],
            [['IdProject'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['IdProject' => 'Id']],
        ];
    }

    public function attributeLabels(){
        return [
            'Id' => 'ID',
            'IdProject' => 'Id Project',
            'Description' => 'Description',
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
