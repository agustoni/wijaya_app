<?php 
	$this->title = "Update";
	$this->params['breadcrumbs'][] = ['label' => 'Purchase Order', 'url' => ['index']];
	$this->params['breadcrumbs'][] = $this->title;
	\yii\web\YiiAsset::register($this);

	$this->registerJsFile('@web/web/js/page_script/purchase_order/create_update.js',['depends' => [\yii\web\JqueryAsset::class]]);
?>

<div class="card card-light mb-3" id="po-form-container">
	<div class="card-header bg-info text-white p-2">
        <h4 class="card-title m-0">Update <?= (isset($_GET['id'])? '#PO'.$model->PoNumber : '' ) ?></h4>
    </div>

<!-- SUPPLIER ADDRESS AND CONTACT -->
    <div class="row mx-1 my-2">
		<div class="col-md-8">
	    	<h5 class="font-weight-bold"><?= $model->supplier__r->Name ?></h5>
	    	<span class="font-weight-bold">Alamat: </span><?= $model->supplier__r->Address ?><br>
	    	<span class="font-weight-bold">Telp Kantor: </span> <?= $model->supplier__r->Phone? $model->supplier__r->Phone : '-' ?><br>
	    
	    	<?php if($model->supplier__r->supplierContact__r): ?>
	    		<p class="font-weight-bold mt-2 mb-0">Kontak Lainya:</p>
		    	<?php foreach($model->supplier__r->supplierContact__r as $cnt): ?>
		    		<span class="font-weight-bold"><?= $cnt->Name ?>: </span><?= $cnt->Phone ?><br>
		    	<?php endforeach; ?>
		    <?php endif; ?>
	    </div>
	    <div class="col-md-4">
	    	<div class="progress" style="height:4rem">
                <div class="progress-bar <?= ($model->ApprovedAt? 'bg-success' : 'bg-danger') ?> border-dark col-md" role="progressbar" style="border: 1px solid">
                    <p>Disetujui</p>    
                    <?= $model->ApprovedAt? "<p>".date('d-m-Y H:i', strtotime($model->ApprovedAt))."</p><p>".$model->approvedBy__r->username."</p>" : '' ?>                       
                </div>

                <div class="progress-bar <?= ($model->ReceivedAt? 'bg-success' : 'bg-danger') ?> border-dark col-md" role="progressbar" style="border: 1px solid">
                    <p>Diterima</p>

                    <?= $model->ReceivedAt? "<p>".date('d-m-Y H:i', strtotime($model->ReceivedAt))."</p><p>".$model->receivedBy__r->username."</p>" : '' ?>                  
                </div>
            </div>
	    </div>
	</div>
	<hr>
<!-- end SUPPLIER ADDRESS AND CONTACT -->

    <?= $this->render('_form', [
        "model" => $model,
        "arrPoItem" => $arrPoItem
    ]) ?>
</div>