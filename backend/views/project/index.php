<?php 

?>
<div class="project-wrapper">
	<div class="row my-2">
		<div class="col-md-3">
			<h2>Data Project</h2>
		</div>
		<div class="col-md-9 text-right">
			<a  class="btn btn-success ml-2" target="_blank" href="<?= yii::$app->urlManager->createUrl(['project/create']); ?>">
                New Project
            </a>
		</div>
	</div>
	<div class="card my-4">
		<div class="card-body">
			<div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th width="10%" class="text-center align-middle">No</th>
                            <th width="25%" class="text-center align-middle">Client</th>
                            <th width="10%" class="text-center align-middle">Status</th>
                            <th width="15%" class="text-center align-middle">Mulai</th>
                            <th width="15%" class="text-center align-middle">Batas Akhir</th>
                            <th width="10%" class="text-center align-middle">Dibuat Oleh</th>
                            <th width="15%" class="text-center align-middle">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
	</div>
</div>
<?php
	$scriptProjectIndex = "
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

	$this->registerJs($scriptProjectIndex, \yii\web\View::POS_END, 'script-index');
?>