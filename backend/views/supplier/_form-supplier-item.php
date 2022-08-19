<?php 
    $this->registerJsFile('@web/web/js/page_script/supplier/_form-supplier-item.js',['depends' => [\yii\web\JqueryAsset::class]]);
?>
<style>
	.select2-container--default .select2-selection--single .select2-selection__arrow {height: 34px;position: absolute;top: 1px;right: 1px;width: 20px;}
	.select2-container--default .select2-selection--single{height: 38px;}
</style>
<div class="card card-light mb-3" id="form-supplier-item">
    <div class="card-header bg-info text-white p-2">
        <h4 class="card-title m-0">Daftar Item</h4>
    </div>
    <div class="card-body">
    	<h5>Tambah Item</h5>
    	<div class="form-row">
    		<div class="col-md-4">
    			<select class="js-example-basic-single form-control supplier_item-IdItem"></select>
    		</div>
    		<div class="col-md-4">
    			<input class="form-control isNumber supplier_item-Stock" placeholder="Stock...">
    		</div>
    		<div class="col-md-2">
    			<button class="btn btn-primary btn-add-supplier-item">Tambah</button>
    		</div>
    	</div>
    <!-- SUPPLIER ITEM -->
    	<div class="table-responsive">
    		<hr>
	    	<div class="pb-3">
	    		<div class="bg-info float-sm-left mt-1 mr-2" style="height: 15px;width: 15px;"></div>
	    		<small class="float-sm-left text-info">Total stock item dari semua supplier</small>
	    	</div><br>
            <table class="table table-bordered" id="dtb-supplier-item" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr>
                        <th width="15%">#</th>
                        <th width="40%">Item</th>
                        <th width="30%">Stock</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody id="supplier-item-list">
                    <?php foreach($model->supplierItem__r as $counter => $spi): ?>
            			<tr>
            				<td class="datatable_input-IdSpc" data-value="<?= $spi->Id ?>">
            					<?= $counter+1 ?>
            				</td>
            				<td class="datatable_input-Name" data-value="<?= $spi->item__r->Name ?>" editmode="true">
            					<?= $spi->item__r->Name ?>
            				</td>
            				<td class="datatable_input-Qty" data-value="<?= $spi->Stock ?>" editmode="true">
            					<?= $spi->Stock ?> / <span class="text-info font-weight-bold"><?= $spi->item__r->itemStock__r->Stock ?></span>
            				</td>
            				<td class="datatable_input-ActionBtn"  editmode="true">
            					<button class="btn btn-sm btn-info btn-edit">
            						<i class="fas fa-pencil-alt"></i>
            					</button>
            				</td>
            			</tr>		
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <!-- END SUPPLIER ITEM -->
    </div>
</div>