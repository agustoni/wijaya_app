<?php
use yii\helpers\Html;
$this->registerCssFile("https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css", ['depends'=> [\yii\bootstrap4\BootstrapAsset::className()]]);
$this->registerJsFile("https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js",['depends' => [\yii\web\JqueryAsset::className()]]);
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
                "model" => $model,
                "supplierContact" => $supplierContact
            ]) ?>
        <!-- END FORM SUPPLIER -->

        <!-- FORM SUPPLIER ITEM  -->
            <?= $this->render('_form-supplier-item', [
                "model" => $model,
                "allItem" => $allItem
            ]) ?>
        <!-- END FORM SUPPLIER ITEM  -->

        <!-- FORM SUPPLIER ITEM COST -->
            <?= $this->render('_form-supplier-item-cost', [
                "model" => $model
            ]) ?>
        <!-- END FORM SUPPLIER ITEM COST -->
    </div>
</div>
<script>
    var idSupplier = <?= $_GET['id']? $_GET['id'] : 'null' ?>;
</script>