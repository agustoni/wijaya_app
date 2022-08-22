<?php 
	$this->title = "Create";
	$this->params['breadcrumbs'][] = ['label' => 'Purchase Order', 'url' => ['index']];
	$this->params['breadcrumbs'][] = $this->title;
	\yii\web\YiiAsset::register($this);

	$this->registerJsFile('@web/web/js/page_script/purchase_order/create_update.js',['depends' => [\yii\web\JqueryAsset::class], 'defer' => 'defer']);
?>

<div class="card card-light mb-3" id="po-form-container">
	<div class="card-header bg-info text-white p-2">
        <h4 class="card-title m-0">Create PO</h4>
    </div>
   
    <?= $this->render('_form', [
        "model" => $model
    ]) ?>
</div>