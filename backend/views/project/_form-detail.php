<div class="project-detail-wrapper">
	<nav>
		<div class="nav nav-tabs" id="nav-tab" role="tablist">
			<a class="nav-item nav-link active" id="nav-detail-data" data-toggle="tab" href="#detail-data" role="tab" aria-controls="detail-data" aria-selected="true">Detail Project</a>
			<a class="nav-item nav-link" id="nav-detail-item" data-toggle="tab" href="#detail-item" role="tab" aria-controls="detail-item" aria-selected="false">Item Project & Harga</a>
			<a class="nav-item nav-link" id="nav-detail-worker" data-toggle="tab" href="#detail-worker" role="tab" aria-controls="detail-worker" aria-selected="false">Pekerja</a>
		</div>
	</nav>
	<div class="tab-content" id="nav-tabContent">
		<div class="tab-pane fade show active" id="detail-data" role="tabpanel" aria-labelledby="detail-data-tab">
			<?= $this->render('_detail-data', [
                "projectType" => $projectType
            ]) ?>
		</div>
		<div class="tab-pane fade" id="detail-item" role="tabpanel" aria-labelledby="detail-item-tab">
			<?= $this->render('_detail-item', [
                // "model" => $model
            ]) ?>
		</div>
		<div class="tab-pane fade" id="detail-worker" role="tabpanel" aria-labelledby="detail-worker-tab">
			<?= $this->render('_detail-worker', [
                // "model" => $model
            ]) ?>
		</div>
	</div>
</div>

<?php
    $scriptProjectFormDetail = "
    	if(actionId == 'create'){
    		
    	}
    ";

    $this->registerJs($scriptProjectFormDetail, \yii\web\View::POS_END);
?>