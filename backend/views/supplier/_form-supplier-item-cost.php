<?php 
    $this->registerJsFile('@web/web/js/page_script/supplier/_form-supplier-item-cost.js',['depends' => [\yii\web\JqueryAsset::class], 'defer' => 'defer']);
?>

<div class="card card-light mb-3" id="form-supplier-item-cost">
    <div class="card-header bg-info text-white p-2">
        <h4 class="card-title m-0">Riwayat Purchase Item</h4>
    </div>
    <div class="card-body p-2">
    	<div class="form-row">
    		<div class="col-md-4">
    			<label class="font-weight-bold" for="supplieritem-search">Cari Data Berdasarkan:</label>
    			<select class="form-control" id="supplieritem-search" name="item" multiple="multiple">
    				<option value="_allitem" selected="selected">Semua Item</option>
					<?php foreach($model->supplierItem__r as $spi): ?>
						<option value="<?= $spi->IdItem ?>"><?= $spi->item__r->Name ?></option>
					<?php endforeach; ?>
				</select>
    		</div>
    	</div>

    <!-- DATA SUPPLIER ITEM COST -->
    	<div class="table-responsive">
    		<hr>
            <table class="table table-bordered" id="dtb-supplier-item-cost" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr>
                        <th width="5%">#</th>
                        <th width="25%">Item</th>
                        <th width="20%">Stock</th>
                        <th width="20%">Harga Beli</th>
                        <th width="20%">Tgl Beli</th>
                        <!-- <th width="10%">Actions</th> -->
                    </tr>
                </thead>
                <tbody id="supplier-item-list">
                    <?php 
                    	$counter = 1;
                    	foreach($model->supplierItem__r as $spi): 
                    		foreach($spi->supplierItemCost__r as $spc):  ?>
                    			<tr>
                    				<td class="spc_input-IdSpc" data-value="<?= $spc->Id ?>">
                    					<?= $counter ?>
                    				</td>
                    				<td class="spc_input-Name" data-value="<?= $spi->item__r->Name ?>" editmode="true">
                    					<?= $spi->item__r->Name ?>
                    				</td>
                    				<td class="spc_input-Qty" data-value="<?= $spc->Qty ?>" editmode="true">
                    					<?= $spc->Qty ?> / <span class="text-info"><?= $spc->supplierItem__r->item__r->itemStock__r->Stock ?></span>
                    				</td>
                    				<td class="spc_input-Price" data-value="<?= $spc->Price ?>" editmode="true">
                    					<?= Yii::$app->formatter->asDecimal($spc->Price, 0) ?>
                    				</td>
                    				<td class="spc_input-CreatedAt" data-value="<?= $spc->CreatedAt ?>" editmode="true">
                    					<?= date("d-m-Y", strtotime($spc->CreatedAt)) ?>
                    				</td>
                    				<!-- <td class="spc_input-ActionBtn" data-value="<?= $spc->Price ?>" editmode="true">
                    					<button class="btn btn-sm btn-success btn-submit d-none">
                    						<i class="fas fa-check"></i>
                    					</button>
                    					<button class="btn btn-sm btn-info btn-edit">
                    						<i class="fas fa-pencil-alt"></i>
                    					</button>
                    					<button class="btn btn-sm btn-danger btn-remove">
                    						<i class="fas fa-times"></i>
                    					</button>
                    				</td> -->
                    			</tr>		
                    <?php		$counter++; 
                			endforeach; 
                    	endforeach; 
                    ?>
                </tbody>
            </table>
        </div>
    <!-- END DATA SUPPLIER ITEM COST -->
    </div>
</div>