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
<?php
    $scriptSupplierCreate = "
    	var urlSaveSupplier = '".Yii::$app->urlManager->createUrl("supplier/save-supplier")."'
    ";

    $this->registerJs($scriptSupplierCreate, \yii\web\View::POS_END);
?>