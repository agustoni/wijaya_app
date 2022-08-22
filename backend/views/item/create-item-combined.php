<?php
use yii\helpers\Html;
$this->registerJsFile('@web/web/js/page_script/item/_form-item-combined.js',['depends' => [\yii\web\JqueryAsset::class], 'defer' => 'defer']);
$this->title = 'Buat Item Kombinasi';
?>
<style>
    .twitter-typeahead {width: 85%;}
    .textarea-item > .twitter-typeahead{width: 85%;}

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
<div class="item-combined-create">
    <div class="row mb-2">
        <div class="col-md-3">
            <h3><?= Html::encode($this->title) ?></h3>
        </div>
    </div>
    <div id="form-item-wrapper">
        <?= $this->render('_form-item-combined', [
            "model" => $model
        ]) ?>   
    </div>
</div>