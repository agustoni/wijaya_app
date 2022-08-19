<?php 
	$this->registerJsFile('@web/web/js/page_script/product/_form.js',['depends' => [\yii\web\JqueryAsset::class]]);
	$this->registerCssFile("https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css", ['depends'=> [\yii\bootstrap4\BootstrapAsset::className()]]);
	$this->registerJsFile("https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js",['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<style>
	#product-item-list td, th{vertical-align: middle}
</style>
<div class="card card-light mb-3" id="product-container">
    <div class="card-header bg-info text-white p-2">
        <h4 class="card-title m-0">Produk</h4>
    </div>
    <div class="car-body p-2">
    	<div class="row mb-2">
    		<div class="col-md-8">
    			<label class="font-weight-bold" for="product_input-Name">Nama Produk</label>
                <input type="text" class="form-control" id="item_input-ItemName" placeholder="Nama Product. . ." name="Product[Name]" value="<?= (isset($model->Name)? $model->Name : '') ?>">
    		</div>
    	</div>
    	<div class="row mb-2">
    		<div class="col-md-8">
    			<label class="font-weight-bold">Item Yang Dibutuhkan</label>
                <select class="form-control select2-itemlist-input"></select>
    		</div>
    	</div>
    	<hr>

    	<h4>List Item Produk</h4>
    	<table class="table table-striped mb-4" id="product-item-list">
    		<thead>
    			<tr>
    				<th style="width: 10%">#</th>
    				<th style="width: 33%">Item</th>
    				<th style="width: 50%">Deskirpsi</th>
    				<th style="width: 7%"></th>
    			</tr>	
    		</thead>
    		<tbody>
    			
    		</tbody>
    	</table>

    	<div class="row float-right">
    		<div class="col-md">
    			<button type="button" class="btn btn-success" id="save_Product">Save</button>
    		</div>
    	</div>
    </div>
</div>
<script>
	var idProduct = "<?= (isset($_GET['id'])? $_GET['id'] : 0) ?>"
	var productItemList = "<?= (isset($productItemList) || !empty($productItemList) ? $productItemList : null) ?>"
	var alertEmpty = $(`<tr id='alert-product-itemlist-empty' class='text-center'><td colspan='4'>Belum ada item yang dimasukan ke product ini</td></tr>`)
</script>