<?php
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

	<div class="card card-light mb-3">
	    <div class="card-header bg-info text-white p-2">
	        <h4 class="card-title m-0">Supplier</h4>
	    </div>
	    <div class="card-body p-2">

	    </div>
	</div>
</div>
<script>
    var dataItemPart = <?= $itemPart ?>;
</script>