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

    public function getAllProduct($q=null){
        $query = Yii::$app->db->createCommand('SELECT 
                                                item__r.Id IdItem, 
                                                item__r.Name ItemName, 
                                                itemUnit__r.UoM UoM, 
                                                productItem__r.Qty, 
                                                productItem__r.Id IdPrdItem, 
                                                product__r.Id IdPrd, 
                                                product__r.Name PrdName,
                                                supplier_item.Id IdSupplierItem, 
                                                idSupplier__r.Id IdSupplier, 
                                                idSupplier__r.Name SupplierName,
                                                supplier_item.Price LastPrice, 
                                                supplier_item.LastUpdated LastUpdated,
                                                supplierItemCost__r.Price PurchasePrice, 
                                                supplierItemCost__r.Created_At PurchaseAt,
                                                if(supplier_item.LastUpdated BETWEEN (NOW() - INTERVAL 14 DAY) AND NOW() OR supplierItemCost__r.Created_At BETWEEN (NOW() - INTERVAL 14 DAY) AND NOW(), 1, 0) StatusExp
                                        FROM `supplier_item` 
                                        LEFT JOIN `item` `item__r` ON supplier_item.IdItem = item__r.Id 
                                        LEFT JOIN `item_unit` `itemUnit__r` ON item__r.IdUoM = itemUnit__r.Id 
                                        LEFT JOIN `supplier_item_cost` `supplierItemCost__r` ON supplier_item.Id = supplierItemCost__r.IdSupplierItem 
                                        LEFT JOIN `supplier` `idSupplier__r` ON supplier_item.IdSupplier = idSupplier__r.Id 
                                        LEFT JOIN `product_item` `productItem__r` on productItem__r.IdItem = item__r.Id
                                        LEFT JOIN `product` `product__r` on product__r.Id = productItem__r.IdProduct
                                        WHERE 
                                            -- product__r.Id = 3
                                            product__r.Name LIKE "%'.$q.'%"
                                        AND supplier_item.LastUpdated = (
                                            SELECT MAX(supplier_item2.LastUpdated)
                                            FROM supplier_item supplier_item2
                                            WHERE supplier_item.IdItem = supplier_item2.IdItem
                                        ) 
                                        -- GROUP BY `item__r`.`Id` 
                                        -- ORDER BY `supplier_item`.`LastUpdated` DESC, `supplierItemCost__r`.`Created_At` DESC, `item__r`.`Name`')->queryAll();

        return $query;
    }

    public function getItemProduct__r(){
        return $this->hasMany(ProductItem::className(), ['IdProduct' => 'Id']);
    }
}
