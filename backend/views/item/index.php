<?php 
	$this->title = "Item Master";
	// $this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
	// $this->params['breadcrumbs'][] = $this->title;
	\yii\web\YiiAsset::register($this);
?>
<div class="item-wrapper">
	<div class="row my-2">
		<div class="col-md-3">
			<h2>Item Master</h2>
		</div>
		<div class="col-md-9 text-right">
			<a  class="btn btn-success ml-2" target="_blank" href="<?= yii::$app->urlManager->createUrl(['item/create']); ?>">
                New Item
            </a>
		</div>
	</div>
	<div class="card my-4">
		<div class="card-body">
			<div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th width="10%" class="text-center">#</th>
                            <th width="20%">Item</th>
                            <th width="30%">Description</th>
                            <th width="15%">Type</th>
                            <!-- <th width="10%">Stock</th> -->
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php foreach($model as $i => $item): ?>
                    		<tr>
                    			<td><?= $i+1 ?></td>
                    			<td><?= $item->Name ?></td>
                    			<td><?= ($item->Description? $item->Description : "-") ?></td>
                    			<td><?= $itemType->itemType[$item->Type] ?></td>
                    			<!-- <td>10</td> -->
                    			<td>
                    				<button class="btn btn-sm btn-outline-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Options
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" target="_blank" href="<?= yii::$app->urlManager->createUrl(['item/view', 'id'=>$item->Id]) ?>">
                                        	<i class="fas fa-eye text-secondary"></i> Lihat
                                        </a>
                                        <!-- <a class="dropdown-item">
                                            <i class="fas fa-trash-alt text-danger"></i> Hapus
                                        </a> -->
                                    </div>
                    			</td>
                    		</tr>
                    	<?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
	</div>
</div>
<?php
	$script="
        $(document).ready(function(){
            $.fn.dataTable.moment( 'MMM D, Y' );
            
            $('#dataTable').DataTable({
                'columnDefs': [
                    {'orderable': true, 'targets': 4 }
                  ],
                'aaSorting': []
            });
        })
    ";

	$this->registerJs($script, \yii\web\View::POS_END, 'script-index');
?>