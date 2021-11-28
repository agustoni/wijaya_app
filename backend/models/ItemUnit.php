<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "item_unit".
 *
 * @property int $Id
 * @property string $UoM
 */
class ItemUnit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item_unit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['UoM'], 'required'],
            [['UoM'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'UoM' => 'Uo M',
        ];
    }
}
