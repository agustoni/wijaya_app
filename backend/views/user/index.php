<?php 
	$this->title = "User Master";
	// $this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
	// $this->params['breadcrumbs'][] = $this->title;
	\yii\web\YiiAsset::register($this);
?>
<div class="user-wrpper">
	<div class="row my-2">
		<div class="col-md-3">
			<h2>User Master</h2>
		</div>
		<div class="col-md-9 text-right">
			<button type="button" class="btn btn-success ml-2" data-href="<?php //yii::$app->urlManager->createUrl(['quotation/create-quotation-header']); ?>">
                New User
            </button>
		</div>
	</div>
	<div class="card my-4">
		<div class="card-body">
			<div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th width="10%" class="text-center">#</th>
                            <th width="50%">User</th>
                            <th width="20%">Role</th>
                            <th width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php for($i=1;$i<=10;$i++): ?>
                    		<tr>
                    			<td><?= $i ?></td>
                    			<td>User</td>
                    			<td>Role</td>
                    			<td>
                    				<button class="btn btn-sm btn-outline-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    	Options
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" target="_blank" href="<?= yii::$app->urlManager->createUrl(['user/view', 'item'=>'a']) ?>">
                                        	<i class="far fa-eye"></i> View
                                        </a>
                                        <a class="dropdown-item" target="_blank" href="<?= yii::$app->urlManager->createUrl(['user/edit', 'item'=>'b']) ?>">
                                        	<i class="far fa-edit"></i> Edit
                                        </a>
                                    </div>
                    			</td>
                    		</tr>
                    	<?php endfor; ?>
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
                    {'orderable': true, 'targets': 3 }
                  ],
                'aaSorting': []
            });
        })
    ";

	$this->registerJs($script, \yii\web\View::POS_END, 'script-index');
?>