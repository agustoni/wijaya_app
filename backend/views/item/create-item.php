<?php
use yii\helpers\Html;

$this->title = 'Buat Item';
?>
<div class="item-create">
    <div class="row mb-2">
        <div class="col-md-3">
            <h3><?= Html::encode($this->title) ?></h3>
        </div>
    </div>
    <div id="form-item-wrapper">
        <?= $this->render('_form-item', [
            "model" => $model
        ]) ?>
    </div>
</div>