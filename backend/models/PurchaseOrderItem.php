<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "purchase_order_item".
 *
 * @property int $Id
 * @property int $IdPO
 * @property int $IdSupplierItem
 * @property int $Qty
 * @property int $Price
 * @property int $Total
 */
class PurchaseOrderItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'purchase_order_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdPo', 'IdSupplierItem', 'Qty', 'Price', 'Total'], 'required'],
            [['Id', 'IdPo', 'IdSupplierItem', 'Qty', 'Price', 'Total'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'IdPo' => 'Id Po',
            'IdSupplierItem' => 'Id Supplier Item',
            'Qty' => 'Qty',
            'Price' => 'Price',
            'Total' => 'Total',
            'DeletedAt' => 'Dihapus',
            'DeletedBy' => 'Dihapus Oleh',
        ];
    }

    public function getPo__r(){
        return $this->hasOne(PurchaseOrder::className(), ['Id' => 'IdPo']);
    }

    public function getSupplierItem__r(){
        return $this->hasOne(SupplierItem::className(), ['Id' => 'IdSupplierItem']);
    }

    public function getDeletedBy__r(){
        return $this->hasOne(User::className(), ['id' => 'DeletedBy']);
    }
}
