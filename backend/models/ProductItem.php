<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product_item".
 *
 * @property int $Id
 * @property int $IdItem
 * @property string $Description
 */
class ProductItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Id', 'IdItem', 'Description'], 'required'],
            [['Id', 'IdItem'], 'integer'],
            [['Description'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'IdItem' => 'Id Item',
            'Description' => 'Description',
        ];
    }

    public function getItem__r(){
        return $this->hasOne(Item::className(), ['Id' => 'IdItem']);
    }
}
