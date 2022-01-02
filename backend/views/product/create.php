<?php 
	use yii\helpers\Html;

	$this->title = 'Create Product';
?>

<div class="product-create">
    <div class="row mb-2">
        <div class="col-md-3">
            <h3><?= Html::encode($this->title) ?></h3>
        </div>
    </div>

    <?= $this->render('_form', [
        // "model" => $model
    ]) ?>
</div>