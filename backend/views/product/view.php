<?php 
	use yii\helpers\Html;
    use yii\helpers\Json;

	$this->title = 'View Product';
?>

<div class="product-view">
    <div class="row mb-2">
        <div class="col-md-3">
            <h3><?= Html::encode($this->title) ?></h3>
        </div>
    </div>

    <?= $this->render('_form', [
        "model" => $model,
        "productItemList" => $productItemList
    ]) ?>
</div>