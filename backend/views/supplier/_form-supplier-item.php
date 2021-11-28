<div class="card card-light mb-3" id="supplier-master-container">
    <div class="card-header bg-info text-white p-2">
        <h4 class="card-title m-0">Item Berdasarkan Supplier</h4>
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
    		<div class="col-md-4">
    			<label>Total Stock</label>
            	<input class="form-control" value="">
    		</div>
    	</div>
    	<!-- DATA ITEM -->
    	<div class="table-responsive">
    		<hr>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr>
                        <th width="5%">#</th>
                        <th width="25%">Item</th>
                        <th width="20%">Stock</th>
                        <th width="20%">Harga Beli</th>
                        <th width="20%">Tgl Beli</th>
                        <th width="10%">Actions</th>
                    </tr>
                </thead>
                <tbody id="supplier-item-list">
                    <?php 
                    	$counter = 1;
                    	// for($i=0;$i<200;$i++):
                    	foreach($model->supplierItem__r as $spi): 
                    		foreach($spi->supplierItemCost__r as $spc):  ?>
                    			<tr>
                    				<td class="datatable_input-IdSpc" data-value="<?= $spc->Id ?>">
                    					<?= $counter ?>
                    				</td>
                    				<td class="datatable_input-Name" data-value="<?= $spi->item__r->Name ?>" editmode="true">
                    					<?= $spi->item__r->Name ?>
                    				</td>
                    				<td class="datatable_input-Qty" data-value="<?= $spc->Qty ?>" editmode="true">
                    					<?= $spc->Qty ?>
                    				</td>
                    				<td class="datatable_input-Price" data-value="<?= $spc->Price ?>" editmode="true">
                    					<?= Yii::$app->formatter->asDecimal($spc->Price, 0) ?>
                    				</td>
                    				<td class="datatable_input-CreatedAt" data-value="<?= $spc->Created_At ?>" editmode="true">
                    					<?= date("d-m-Y", strtotime($spc->Created_At)) ?>
                    				</td>
                    				<td class="datatable_input-ActionBtn" data-value="<?= $spc->Price ?>" editmode="true">
                    					<button class="btn btn-sm btn-success btn-submit d-none">
                    						<i class="fas fa-check"></i>
                    					</button>
                    					<button class="btn btn-sm btn-info btn-edit">
                    						<i class="fas fa-pencil-alt"></i>
                    					</button>
                    					<button class="btn btn-sm btn-danger btn-remove">
                    						<i class="fas fa-times"></i>
                    					</button>
                    				</td>
                    			</tr>		
                    <?php		$counter++; 
                			endforeach; 
                    	endforeach; 
                    // endfor;
                    ?>
                </tbody>
            </table>
        </div>
        <!-- END DATA ITEM -->
    </div>
</div>

<?php 
	$this->registerCssFile("https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css", [
        'depends'=> [
            \yii\bootstrap4\BootstrapAsset::className()
        ],
        'position' => \yii\web\View::POS_END
    ]);
    
    $this->registerJsFile("https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js",[
        'depends' => [
            \yii\web\JqueryAsset::className()
        ],
        'position' => \yii\web\View::POS_END
    ]);

    $scriptFormSupplierItem = "
    	$(document).ready(function() {
    		$('body').on('click', '.btn-edit', function(){
    			$(this).parents('tr').find('td[class^=datatable_input-]').each(function(){
    				// $(this).html()
    				editMode($(this))
    			})
    		})

    		function editMode(el){
    			if(el.attr('editmode')){
    				var value = el.attr('data-value')
    				var className = el.attr('class')

    				if(className == 'datatable_input-ActionBtn'){
    					el.find('button.btn-success').removeClass('d-none')
    					el.find('button.btn-edit').addClass('d-none')
    					el.find('button.btn-remove').addClass('d-none')
					}else{
						el.empty()

						var input = $(`
		    				<input class='form-control `+className+`' value='`+value+`'>
		    			`)
		    			el.append(input)
					}
				}else{
					if(className == 'datatable_input-ActionBtn'){
    					el.find('button.btn-success').addClass('d-none')
    					el.find('button.btn-edit').removeClass('d-none')
    					el.find('button.btn-remove').removeClass('d-none')
					}
				}
    		}

            $('#supplieritem-search').select2();

            $.fn.dataTable.moment( 'MMM D, Y' );
            
            $('#dataTable').DataTable({
                'columnDefs': [
                    { 'orderable': false, 'targets': 5 }
                  ],
                'aaSorting': []
            });
        });
    ";

    $this->registerJs($scriptFormSupplierItem, \yii\web\View::POS_END);
?>