<?php

namespace backend\models;

use Yii;

class ProjectAmount extends \yii\db\ActiveRecord{
    
    public static function tableName(){
        return 'project_amount';
    }

    public function rules(){
        return [
            [['IdProject', 'Amount', 'Cost', 'Balance', 'MarginPercent', 'MarginNominal'], 'required'],
            [['IdProject'], 'integer'],
            [['Amount', 'Cost', 'Balance', 'MarginPercent', 'MarginNominal'], 'number'],
            [['IdProject'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['IdProject' => 'Id']],
        ];
    }

    public function attributeLabels(){
        return [
            'Id' => 'ID',
            'IdProject' => 'Id Project',
            'Amount' => 'Amount',
            'Cost' => 'Cost',
            'Balance' => 'Balance',
            'MarginPercent' => 'Margin Percent',
            'MarginNominal' => 'Margin Nominal',
        ];
    }

    public function getIdProject__r(){
        return $this->hasOne(Project::className(), ['Id' => 'IdProject']);
    }
}
