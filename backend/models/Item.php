<?php

namespace backend\models;

use Yii;

class Item extends \yii\db\ActiveRecord{
    // jenis item internal atau item project
    public $itemType = [
        1 => "Siap Pakai", 
        2 => "Kombinasi",
        3 => "Jasa",
        4 => "Part"
    ];
    
    public static function tableName(){
        return 'item';
    }

    public function rules(){
        return [
            [['Name', 'Type'], 'required'],
            [['Description'], 'string'],
            [['Type'], 'integer'],
            [['Name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels(){
        return [
            'Id' => 'ID',
            'Name' => 'Name',
            'Description' => 'Deskripsi',
            'Type' => 'Tipe',
            'IdUoM' => 'UoM'
        ];
    }

    public function getSalesItem($q, $idSupplier){
        $data = Yii::$app->db->createCommand('SELECT 
                                                    item__r.Id IdItem, 
                                                    item__r.Name ItemName, 
                                                    itemUnit__r.UoM, 
                                                    supplier_item.Id IdSupplierItem, 
                                                    idSupplier__r.Id IdSupplier, 
                                                    idSupplier__r.Name SupplierName,
                                                    supplier_item.Price LastPrice, 
                                                    supplier_item.LastUpdated LastUpdated,
                                                    supplierItemCost__r.Price PurchasePrice, 
                                                    supplierItemCost__r.CreatedAt PurchaseAt,
                                                    if(supplier_item.LastUpdated BETWEEN (NOW() - INTERVAL 14 DAY) AND NOW() OR supplierItemCost__r.CreatedAt BETWEEN (NOW() - INTERVAL 14 DAY) AND NOW(), 1, 0) StatusExp
                                            FROM `supplier_item` 
                                            LEFT JOIN `item` `item__r` ON supplier_item.IdItem = item__r.Id 
                                            LEFT JOIN `item_unit` `itemUnit__r` ON item__r.IdUoM = itemUnit__r.Id 
                                            LEFT JOIN `supplier_item_cost` `supplierItemCost__r` ON supplier_item.Id = supplierItemCost__r.IdSupplierItem AND Flag = 1
                                            LEFT JOIN `supplier` `idSupplier__r` ON supplier_item.IdSupplier = idSupplier__r.Id 
                                            WHERE item__r.Name LIKE "%'.$q.'%"'
                                            .($idSupplier? " AND supplier_item.IdSupplier = ".$idSupplier : "").'
                                            /*AND (
                                                supplier_item.LastUpdated BETWEEN (NOW() - INTERVAL 14 DAY) AND NOW()
                                                OR supplierItemCost__r.CreatedAt BETWEEN (NOW() - INTERVAL 14 DAY) AND NOW()
                                            )*/
                                            AND supplier_item.LastUpdated = (
                                                SELECT MAX(supplier_item2.LastUpdated)
                                                FROM supplier_item supplier_item2
                                                WHERE supplier_item.IdItem = supplier_item2.IdItem
                                            ) GROUP BY `item__r`.`Id` 
                                            ORDER BY `supplier_item`.`LastUpdated` DESC, `supplierItemCost__r`.`CreatedAt` DESC, `item__r`.`Name`')->queryAll();

        

        return $data;
    }

    public function getSupplierItem($id){
        $data = Yii::$app->db->createCommand('SELECT 
                                                    item__r.Id IdItem, 
                                                    item__r.Name ItemName, 
                                                    itemUnit__r.UoM, 
                                                    supplier_item.Id IdSupplierItem, 
                                                    idSupplier__r.Id IdSupplier, 
                                                    idSupplier__r.Name SupplierName,
                                                    supplier_item.Price LastPrice, 
                                                    supplier_item.LastUpdated LastUpdated,
                                                    supplierItemCost__r.Price PurchasePrice, 
                                                    supplierItemCost__r.CreatedAt PurchaseAt,
                                                    if(supplier_item.LastUpdated BETWEEN (NOW() - INTERVAL 14 DAY) AND NOW() OR supplierItemCost__r.CreatedAt BETWEEN (NOW() - INTERVAL 14 DAY) AND NOW(), 1, 0) StatusExp
                                            FROM `supplier_item` 
                                            LEFT JOIN `item` `item__r` ON supplier_item.IdItem = item__r.Id 
                                            LEFT JOIN `item_unit` `itemUnit__r` ON item__r.IdUoM = itemUnit__r.Id 
                                            LEFT JOIN `supplier_item_cost` `supplierItemCost__r` ON supplier_item.Id = supplierItemCost__r.IdSupplierItem AND Flag = 1
                                            LEFT JOIN `supplier` `idSupplier__r` ON supplier_item.IdSupplier = idSupplier__r.Id 
                                            WHERE item__r.Id = '.$id.'
                                            ORDER BY `supplier_item`.`LastUpdated` DESC, `supplierItemCost__r`.`CreatedAt` DESC, `item__r`.`Name`')->queryAll();

        return $data;
    }

    public function getItemUnit__r(){
        return $this->hasOne(ItemUnit::className(), ['Id' => 'IdUoM']);
    }

    public function getItemPart__r(){
        return $this->hasMany(ItemPart::className(), ['IdItem' => 'Id']);
    }

    public function getItemPartParent__r(){
        return $this->hasMany(ItemPart::className(), ['IdParentItem' => 'Id']);
    }

    public function getItemStock__r(){
        return $this->hasMany(ItemStock::className(), ['IdItem' => 'Id']);
    }

    public function getProReqItem__r(){
        return $this->hasMany(ProductionRequestItem::className(), ['IdItem' => 'Id']);
    }

    public function getProjectItem__r(){
        return $this->hasMany(ProjectItem::className(), ['IdItem' => 'Id']);
    }

    public function getQuotationItem__r(){
        return $this->hasMany(QuotationItem::className(), ['IdItem' => 'Id']);
    }

    public function getSupplierItem__r(){
        return $this->hasMany(SupplierItem::className(), ['IdItem' => 'Id']);
    }
}
