<?php 
	$this->title = "Supplier Master";
	// $this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
	// $this->params['breadcrumbs'][] = $this->title;
	\yii\web\YiiAsset::register($this);
?>
<div class="item-wrapper">
	<div class="row my-2">
		<div class="col-md-3">
			<h2>Supplier Master</h2>
		</div>
		<div class="col-md-9 text-right">
			<a type="button" class="btn btn-success ml-2" target="_blank" href="<?= yii::$app->urlManager->createUrl(['supplier/create']) ?>">
                New Supplier
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
                            <th width="30%">Supplier</th>
                            <th width="30%">Address</th>
                            <th width="20%">Description</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php foreach($model as $i => $spl): ?>
                    		<tr>
                    			<td><?= $i+1 ?></td>
                    			<td><?= $spl->Name ?></td>
                    			<td><?= ($spl->Address? $spl->Address : '-') ?></td>
                                <td><?= ($spl->Description? $spl->Description : '-') ?></td>
                    			<td>
                    				<button class="btn btn-sm btn-outline-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Options
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" target="_blank" href="<?= yii::$app->urlManager->createUrl(['supplier/view', 'id'=> $spl->Id]) ?>">
                                        	<i class="fas fa-eye text-secondary"></i> View
                                        </a>
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
	$scriptSupplierIndex="
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

	$this->registerJs($scriptSupplierIndex, \yii\web\View::POS_END, 'script-index');
?>