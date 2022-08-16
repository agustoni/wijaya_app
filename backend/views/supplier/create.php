<?php
use yii\helpers\Html;

$this->title = 'Create Supplier';
?>
<div class="item-create">
    <div class="row mb-2">
        <div class="col-md-3">
            <h3><?= Html::encode($this->title) ?></h3>
        </div>
    </div>
    <div id="form-supplier-wrapper">
    	<!-- FORM SUPPLIER -->
            <?= $this->render('_form', [
                "model" => $model
            ]) ?>
        <!-- END FORM SUPPLIER -->
    </div>
</div>