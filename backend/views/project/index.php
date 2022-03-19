<?php 
    $arrData = [
        "0" =>['IdProject' => 'P300122001','Client' => 'PT Lintas Batas','Status' => '1','Start' => '2022-02-11','End' => '2022-05-07','CreatedBy' => 'Joko'],
        "1" =>['IdProject' => 'P281021001','Client' => 'Sugeng','Status' => '1','Start' => '2022-02-11','End' => '2022-05-07','CreatedBy' => 'Joko'],
        "2" =>['IdProject' => 'P281021002','Client' => 'Kimia Farma','Status' => '2','Start' => '2022-01-01','End' => '2022-12-31','CreatedBy' => 'Lucky'],
        "3" =>['IdProject' => 'P171021001','Client' => 'Kimia Farma','Status' => '2','Start' => '2022-03-13','End' => '2022-07-07','CreatedBy' => 'Joko'],
        "4" =>['IdProject' => 'P151021001','Client' => 'PT Kuda Laut','Status' => '0','Start' => '2022-01-15','End' => '2022-05-07','CreatedBy' => 'Lucky'],
    ];
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
                        <?php foreach($arrData as $dt): ?>
                            <tr>
                                <td>
                                    <a href='<?= yii::$app->urlManager->createUrl(['project/view', 'id'=>$dt['IdProject']]); ?>' target="_blank"><?= $dt['IdProject'] ?></a>
                                </td>
                                <td>
                                    <?= $dt['Client'] ?>
                                </td>
                                <td>
                                    <?php 
                                        if($dt['Status'] == 0){
                                            echo '<span class="badge badge-danger">Cancel</span>';
                                        }else if($dt['Status'] == 1){
                                            echo '<span class="badge badge-info">Menunggu pihak client</span>';
                                        }else{
                                            echo '<span class="badge badge-success">On Progress</span>';
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?= date("d/M/y", strtotime($dt['Start'])) ?>
                                </td>
                                <td>
                                    <?= date("d/M/y", strtotime($dt['End'])) ?>
                                </td>
                                <td>
                                    <?= $dt['CreatedBy'] ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-info dropdown-toggle" type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Options
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#"><i class="fas fa-file-export"></i> Quotation</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#"><i class="fas fa-file-export"></i> Invoice</a>
                                        <?php  if($dt['Status'] == 2){ ?>
                                            <a class="dropdown-item" href="<?= yii::$app->urlManager->createUrl(['purchase-order/create', 'id'=>$dt['IdProject']]); ?>" target="_blank"><i class="fas fa-cart-plus"></i> Invoice</a>  
                                        <?php } ?>
                                        <!-- <a class="dropdown-item" target="_blank" href="<?php // yii::$app->urlManager->createUrl(['project/edit', 'id' => $dt['IdProject']]); ?>"><i class="far fa-edit"></i> Edit </a> -->
                                    </div>
                                </td>
                            </tr>   
                        <?php endforeach ?>
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