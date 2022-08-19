<?php
	// $this->registerCssFile("https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css", ['depends'=> [\yii\bootstrap4\BootstrapAsset::className()]]);
 //    $this->registerJsFile("https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js",['depends' => [\yii\web\JqueryAsset::className()]]);

	$this->title = 'View Item';
?>

<div id="view-item-container">
	<!-- UPDATE ITEM MASTER -->
	<?= $this->render('_form-item', [
                "model" => $model
    ]) ?>
    <!-- END UPDATE ITEM MASTER -->

    <!-- UPDATE ITEM PART -->
	<?php if($model->Type == 2){ ?>
		<?= $this->render('_form-item-combined', [
                "model" => $model
        ]) ?>
	<?php } ?>
	<!-- END UPDATE ITEM PART -->

	<!-- FORM ITEM SUPPLIER -->
		<?= $this->render('_form-supplier-item', [
                "model" => $model
        ]) ?>
	<!-- END FORM ITEM SUPPLIER -->
</div>
<script>
    var dataItemPart = <?= $itemPart ?>;
</script>