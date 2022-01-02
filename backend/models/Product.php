<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $Id
 * @property int|null $IdType
 * @property string $Name
 * @property int $Status
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Name'], 'required'],
            [['Id', 'IdType', 'Status'], 'integer'],
            [['Name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'IdType' => 'Id Type',
            'Name' => 'Name',
            'Status' => 'Status',
        ];
    }

    public function getItemProduct__r(){
        return $this->hasMany(ProductItem::className(), ['IdProduct' => 'Id']);
    }
}
