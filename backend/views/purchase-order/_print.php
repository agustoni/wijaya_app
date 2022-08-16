<div class="purchase-order-pdf-view">
	 <div class="col-xs-6">
        <table class="table table-content table-sent-to">
            <tr>
                <td style="border-bottom:1px solid black"><b>Dikirim Ke : </b></td>
            </tr>
            <tr>
                <td>
                    <b><?= $model->supplier__r->Name ?></b><br>
                    <?= $model->supplier__r->Address ?><br>
                    <?= !empty($model->supplier__r->Phone) ? 'Phone : '.$model->supplier__r->Phone.'<br>':'' ?>
                    <?php // !empty($model->purchaseOrderAddress->to_fax) ? 'Fax : '.$model->purchaseOrderAddress->to_fax.'<br>':'' ?>
                    <?php //!empty($model->purchaseOrderAddress->to_email) ? 'Email : '.$model->purchaseOrderAddress->to_email.'<br>':'' ?>
                </td>
            </tr>
        </table>
    </div>
    <div class="col-xs-1">
        <table>
            <tr>
                <td></td>
            </tr>
        </table>
    </div>
    <div class="col-xs-5">
        <div class="col-xs-8" style="margin-bottom: 10px; float:right">
            <p style="text-align:right; padding-bottom:15px; padding-right:15px; border-bottom:8px solid #757d84; border-right:8px solid #757d84">
            	<b>Tanggal : <?= date('d-m-Y', strtotime($model->CreatedAt)) ?></b>
            	<?php // Yii::$app->formatter->asDate($model->CreatedAt, 'php:M j, Y') ?>
            </p>
        </div>
        <div class="col-xs-10" style="float:right">
            <table class="table table-content table-type" style="border: 3px solid black">
                <tr>
                    <td style="font-size: 1.5rem; font-weight: bold; text-align: center;"><i>Purchase Order</i></td>
                </tr>
                <tr>
                    <td style="text-align: center; font-weight: bold;"><i><?= $model->PoNumber ?></i></td>
                </tr>
            </table>
        </div>   
    </div>

    <table class="table table-item" width="100%" cellpadding="5" cellspacing="5">
        <thead>
            <tr>
                <th style="width: 5%;  text-align: center;">No</th>
                <th style="width: 45%; ">Item</th>
                <th style="width: 8%; ">Qty</th>
                <th style="width: 8%;  text-align: center;">UoM</th>
                <th style="width: 17%; text-align: center;">Harga Unit</th>
                <th style="width: 17%; text-align: center;">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 0;
            foreach ($model->poItem__r as $no => $item) {
                $no++;
            ?>
                <tr>
                    <td style="text-align: center; " ><?= $no ?></td>
                    <td ><?= $item->supplierItem__r->item__r->Name ?></td>
                    <td style="text-align: center; "><?= $item->Qty ?></td>
                    <td style="text-align: center; "><?= $item->supplierItem__r->item__r->itemUnit__r->UoM ?></td>
                    <td>
	                    Rp <?= Yii::$app->FormatingNumber->Decimal($item->Price) ?>
                    </td>
                    <td>
                        Rp <?= Yii::$app->FormatingNumber->Decimal($item->Total) ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="col-xs-4 offset-8">
        <table class="table table-item table-total">
            <tr>
                <td style="text-align: left; font-weight: bold;">Grand Total</td>
                <td style="text-align: right; font-weight: bold;">Rp <?= Yii::$app->FormatingNumber->Decimal($model->Total) ?></td>
            </tr>
        </table>
    </div>

    <div class="col-xs-4 offset-8">
        <table class="table">
            <tr>
                <td style="text-align: center;">
                	Jakarta, <?= date('d-m-Y', strtotime($model->CreatedAt)) ?>
	                <img src="<?= Yii::getAlias('@web').'/web/images/logos/signature.jpg' ?>" class="img-responsive"><br><br>
	                Luc Ky
	            </td>
            </tr>
        </table>
    </div>
</div>