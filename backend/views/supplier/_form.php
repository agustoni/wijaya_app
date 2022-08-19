<?php 
    $this->registerJsFile('@web/web/js/page_script/supplier/_form.js',['depends' => [\yii\web\JqueryAsset::class]]);
?>

<div class="card card-light mb-3" id="form-supplier">
    <div class="card-header bg-info text-white p-2">
        <h4 class="card-title m-0">Supplier Master</h4>
    </div>
    <div class="card-body p-2">
    <!-- MASTER SUPPLIER -->
    	<div class="form-row">
            <div class="form-group col-md-5">
                <label class="font-weight-bold" for="supplier_input-Name">Nama Supplier</label>
                <input type="text" class="form-control" id="supplier_input-Name" placeholder="Nama Supplier. . ." name="Supplier[Name]" value="<?= ($model->Name? $model->Name : '') ?>">
                <!-- <input type="text" class="form-control" id="supplier_input-IdSupplier" name="Supplier[IdSupplier]" value="<?= ($model->Id? $model->Id : '') ?>"> -->
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-5">
                <label class="font-weight-bold" for="supplier_input-Address">Alamat</label>
                <textarea class="form-control" id="supplier_input-Address" rows=3 placeholder="Alamat. . ." name="Supplier[Address]"><?= ($model->Address? $model->Address : '') ?></textarea>
            </div>
            <div class="form-group col-md-5 offset-md-1">
            	<label class="font-weight-bold" for="supplier_input-Description">Keterangan</label>
                <textarea class="form-control" id="supplier_input-Description" rows=3 placeholder="Keterangan. . ." name="Supplier[Description]"><?= ($model->Description? $model->Description : '') ?></textarea>
            </div>
        </div>
    <!-- END MASTER SUPPLIER -->

    <!-- CONTACT -->
        <hr>
        <h4>Kontak</h4>
        <div class="form-row form-label">
    		<div class="col-md-1 text-center"><label class="font-weight-bold">#</label></div>
    		<div class="col-md-3"><label class="font-weight-bold">Nama</label></div>
            <div class="col-md-3"><label class="font-weight-bold">Phone</label></div>
    	</div>
    	<div id="supplier-contact-list">

        </div>
        <div class="form-row mt-4">
        	<div class="col-md-6">
        		<button class="btn btn-warning" id="btn-add-suppliercontact"><i class="fas fa-plus text-white"></i></button>
        	</div>
            <div class="col-md-6 text-right">
                <button type="button" class="btn btn-success" id="save_Supplier">Save</button>
            </div>
        </div>
    <!-- END CONTACT -->
    </div>
</div>
<script>
    var actionId = '<?= Yii::$app->controller->action->id ?>';
    var supplierContact = <?= (!empty($supplierContact)? $supplierContact : 'null') ?>;
    var idSupplier = <?= isset($_GET['id'])? $_GET['id'] : 'null' ?>;
</script>