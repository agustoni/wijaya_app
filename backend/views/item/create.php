<?php

use yii\helpers\Html;

$this->registerCssFile("@web/web/css/select2.min.css", [
    'depends'=> [
        \yii\bootstrap4\BootstrapAsset::className()
    ]
]);

$this->registerJsFile("@web/web/js/select2.min.js",[
    'depends' => [
        \yii\web\JqueryAsset::className()
    ],
    'position' => \yii\web\View::POS_END
]);

$this->title = 'Create Item';
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
<div class="item-create">
    <div class="row mb-2">
        <div class="col-md-3">
            <h3><?= Html::encode($this->title) ?></h3>
        </div>
    </div>
    <div id="form-item-wrapper">
        <!-- ITEM MASTER -->
            <?= $this->render('_form-item-master', [
                "model" => $model
            ]) ?>
        <!-- END ITEM MASTER -->

        <!-- ITEM PART -->
            <?= $this->render('_form-item-part', [
                "model" => $model
            ]) ?>
        <!-- END ITEM PART -->
    </div>
</div>
<?php
    $scriptItemCreate="
        var urlSaveItem = '".Yii::$app->urlManager->createUrl("item/save-item")."'
    ";

    $this->registerJs($scriptItemCreate, \yii\web\View::POS_END);
?>