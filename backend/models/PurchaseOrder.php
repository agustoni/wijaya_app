<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "purchase_order".
 *
 * @property int $Id
 * @property int $IdPo
 * @property string $PoNumber
 * @property string $IdSupplier
 * @property int $Total
 * @property int|null $ReceivedAt
 * @property int|null $ReceivedBy
 * @property int|null $ApprovedAt
 * @property int|null $ApprovedBy
 * @property int|null $CanceledAt
 * @property int|null $CanceledBy
 * @property int $Status 0=cancel, 1=approve, 2=waiting
 */
class PurchaseOrder extends \yii\db\ActiveRecord{
    public static function tableName(){
        return 'purchase_order';
    }

    public function rules(){
        return [
            [['IdSupplier', 'Total'], 'required'],
            [['Total', 'Status'], 'integer'],
            [['IdSupplier'], 'safe'],
            [['PoNumber'], 'string', 'max' => 50],
        ];
    }

    public function afterSave($insert, $changedAttributes){
        if($insert){
            $incrementPo = PurchaseOrder::find()->where("PoNumber LIKE '%".date("ymd")."%'")->count();
            $incrementPo++;
            $poNo = date("ymd").str_pad($incrementPo,3,"0",STR_PAD_LEFT);

            $this->PoNumber = $poNo;
            $this->updateAttributes(['PoNumber']);
        }
    }

    public function attributeLabels(){
        return [
            'Id' => 'ID',
            'PoNumber' => 'Po Number',
            'IdSupplier' => 'Id Supplier',
            'Total' => 'Total',
            'ReceivedAt' => 'Diterima',
            'ReceivedBy' => 'Diterima Oleh',
            'ApprovedAt' => 'Disetujui',
            'ApprovedBy' => 'Disetujui Oleh',
            'CanceledAt' => 'Dibuat',
            'CanceledBy' => 'Dibuat Oleh',
            'Status' => 'Status',
        ];
    }

    public function getPoItem__r(){
        return $this->hasMany(PurchaseOrderItem::className(), ['IdPo' => 'Id'])->andOnCondition(['is', 'purchase_order_item.DeletedAt', new \yii\db\Expression('null')]);
    }

    public function getPoItemAll__r(){
        return $this->hasMany(PurchaseOrderItem::className(), ['IdPo' => 'Id']);
    }

    public function getSupplier__r(){
        return $this->hasOne(Supplier::className(), ['Id' => 'IdSupplier']);
    }

    public function getReceivedBy__r(){
        return $this->hasOne(User::className(), ['id' => 'ReceivedBy']);
    }

    public function getApprovedBy__r(){
        return $this->hasOne(User::className(), ['id' => 'ApprovedBy']);
    }

    public function getCreatedBy__r(){
        return $this->hasOne(User::className(), ['id' => 'CreatedBy']);
    }

    public function getCanceled__r(){
        return $this->hasOne(User::className(), ['id' => 'CanceledBy']);
    }

    // public function getBASTBy__r(){
    //     return $this->hasOne(User::className(), ['id' => 'BAST_By']);
    // }
}
