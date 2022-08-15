<?php
    use yii\helpers\Html;

    $this->title = 'View Project '.$id;
?>

<div class="project-create">
    <div class="row mb-2">
        <div class="col-md-4">
            <h3><?= Html::encode($this->title) ?></h3>
            <span class="badge badge-success">On Progress</span>
        </div>
        <!-- <div class="col-md-8">
        	<div class="input-group">
			  	<button class="btn btn-primary" type="button">Quotation</button>
			  	<button class="btn btn-warning text-white" type="button">Invoice</button>
			</div>
        </div> -->
    </div>
    <div class="form-project-wrapper" id="smartwizard">
        <?= $this->render('_form-wrapper', [
                "id" => $id,
                "projectType" => $projectType,
                "dataProject" => $dataProject
        ]) ?>
    </div>
</div>
<script>
    var actionId = 'view'
    var dataProject = <?= $dataProject ?>;

</script>