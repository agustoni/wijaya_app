<?php
use yii\helpers\Html;

$this->title = 'View Supplier';
?>

<div class="item-create">
    <div class="row mb-2">
        <div class="col-md-3">
            <h3><?= Html::encode($this->title) ?></h3>
        </div>
    </div>
    <div id="form-supplier-wrapper">
    	<!-- FORM SUPPLIER -->
            <?= $this->render('_form', [
                "model" => $model
            ]) ?>
        <!-- END FORM SUPPLIER -->

        <!-- FORM SUPPLIER ITEM -->
            <?= $this->render('_form-supplier-item', [
                "model" => $model
            ]) ?>
        <!-- END FORM SUPPLIER ITEM -->
    </div>
</div>
<?php
    $scriptSupplierView = "
        var supplierContact = ".(!empty($supplierContact)? $supplierContact : 'null')." 
    	var urlSaveSupplier = '".Yii::$app->urlManager->createUrl(["supplier/save-supplier", 'id'=>$_GET['id']])."'
    ";

    $this->registerJs($scriptSupplierView, \yii\web\View::POS_END);
?>