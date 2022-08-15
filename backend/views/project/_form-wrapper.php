<?php
    $this->registerCssFile("@web/web/css/jquery-ui.css", ['depends'=> [\yii\bootstrap4\BootstrapAsset::className()]]);
    $this->registerJsFile("@web/web/js/jquery-ui.js", ['depends'=> [\yii\bootstrap4\BootstrapAsset::className()]]);
    $this->registerCssFile("@web/web/css/select2.min.css", ['depends'=> [\yii\bootstrap4\BootstrapAsset::className()]]);
    $this->registerJsFile("@web/web/js/select2.min.js", ['depends'=> [\yii\bootstrap4\BootstrapAsset::className()]]);
    $this->registerJsFile("@web/web/js/ckeditor/ckeditor.js", ['depends'=> [\yii\bootstrap4\BootstrapAsset::className()]]);
    $this->registerCssFile("@web/web/css/smart_wizard.css", ['depends'=> [\yii\bootstrap4\BootstrapAsset::className()]]);
    $this->registerCssFile("@web/web/css/smart_wizard_arrows.css", ['depends'=> [\yii\bootstrap4\BootstrapAsset::className()]]);
    $this->registerJsFile("@web/web/js/jquery.smartWizard.js",['depends' => [\yii\web\JqueryAsset::className()]]);
    $this->registerJsFile('@web/web/js/page_script/project/create_update.js',['depends' => [\yii\web\JqueryAsset::class]]);
?>
<style>
    .ui-datepicker {z-index: 999 !important;}
    input[readonly], select[readonly]{pointer-events: none;}
    #upload-file-container{border-width: 2px !important;min-height: 250px;background: #d0f8ff;}
    .focus#upload-file-container{color: #495057;background-color: #bfd7de;border-color: #80bdff;outline: 0;box-shadow: 0 0 0.1rem 0.2rem rgb(0 123 255 / 25%);transition-duration:0.2s;}
    span.div-placeholder{font-size: 35px;font-weight: 600;}

    #upload-file-container .file-name{height: 50px;overflow-y: auto;}
    .remove-file{cursor: pointer;border: 1px solid;border-radius: 15px;padding: 3px 5px;top: 0;right: 0;background: #ff3434;}
    i.remove-file:hover{background: #e68989;transition: 0.2s;}

    #form-sales-item td:nth-child(1){width: 5%;}
    #form-sales-item td:nth-child(2){width: 35%;}
    #form-sales-item td:nth-child(3){width: 30%;}
    #form-sales-item td:nth-child(4){width: 15%;}
    #form-sales-item td:nth-child(5){width: 15%;}
    .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {color: #ffffff;background-color: #17a2b8;border-color: #dee2e6 #dee2e6 #fff;}

    .table-product-item td:nth-child(1){width: 6%}
    .table-product-item td:nth-child(2){width: 18%}
    .table-product-item td:nth-child(3){width: 15%}
    .table-product-item td:nth-child(4){width: 11%}
    .table-product-item td:nth-child(5){width: 25%}
    .table-product-item td:nth-child(6){width: 18%}
    .table-product-item td:nth-child(7){width: 7%}

    .table-product-item tfoot{border-top: 2px solid #eee;background-color: #eee;}

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /*.twitter-typeahead {width: 85%;}
    .textarea-item > .twitter-typeahead{width: 85%;}

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }*/
</style>
<ul class="nav">
    <li>
        <a class="nav-link" href="#data-client">
            Client
        </a>
    </li>
    <li>
        <a class="nav-link" href="#data-detail">
            Detail
        </a>
    </li>
    <li>
        <a class="nav-link" href="#data-payment">
            Payment
        </a>
    </li>
</ul>
<div class="tab-content">
    <!-- DATA PROJECT CLIENT -->
        <div id="data-client" class="tab-pane" role="tabpanel">
            <?= $this->render('_form-client', [
                // "model" => $model
            ]) ?>
        </div>
    <!-- END DATA PROJECT CLIENT -->

    <!-- DATA PROJECT DETAIL -->
        <div id="data-detail" class="tab-pane" role="tabpanel">
            <?= $this->render('_form-detail', [
                "projectType" => $projectType
            ]) ?>
        </div>
    <!-- END DATA PROJECT DETAILT -->

    <!-- DATA PROJECT PAYMENT -->
        <div id="data-payment" class="tab-pane" role="tabpanel">
            <?= $this->render('_form-payment', [
                // "model" => $model
            ]) ?>
        </div>
    <!-- END DATA PROJECT PAYMENT -->
</div>