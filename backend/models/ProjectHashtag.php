<?php

namespace backend\models;

use Yii;

class ProjectHashtag extends \yii\db\ActiveRecord{
    
    public static function tableName(){
        return 'project_hashtag';
    }

    public function rules(){
        return [
            [['Hashtag'], 'required'],
            [['Hashtag'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels(){
        return [
            'Id' => 'ID',
            'Hashtag' => 'Hashtag',
        ];
    }
}
