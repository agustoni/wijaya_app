<?php 
    $this->registerJsFile('@web/web/js/page_script/item/_form-item.js',['depends' => [\yii\web\JqueryAsset::class], 'defer' => 'defer']);
    $this->registerCssFile("https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css", ['depends'=> [\yii\bootstrap4\BootstrapAsset::className()]]);
    $this->registerJsFile("https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js",['depends' => [\yii\web\JqueryAsset::className()]]);
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
<!-- FORM ITEM -->
<div class="card card-light mb-3" id="item-master-container">
    <div class="card-header bg-info text-white p-2">
        <h4 class="card-title m-0">Item Master</h4>
    </div>
    <div class="card-body p-2">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label class="font-weight-bold" for="item_input-ItemName">Nama Barang</label>
                <input type="text" class="form-control" id="item_input-ItemName" placeholder="Nama Barang. . ." name="Item[Name]" value="<?= ($model->Name? $model->Name : '') ?>" data-iditem="<?= $model->Id? $model->Id : null ?>" <?= Yii::$app->controller->action->id == 'view'? 'readonly' : '' ?>>
            </div>
            <div class="form-group col-md-4 offset-md-1">
                <label class="font-weight-bold" for="item_input-ItemType">Jenis</label>
                <select class="form-control" id="item_input-ItemType" name="Item[Type]" <?= Yii::$app->controller->action->id == 'view'? 'disabled' : '' ?>>
                    <option value="">- Select Type -</option>
                    <?php foreach($model->itemType as $idType => $ty): ?>
                        <option value="<?= $idType ?>" <?= $model->Type == $idType? "selected" : "" ?>><?= $ty ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <label class="font-weight-bold" for="item_input-IdUoM">UoM</label><br>
                <input type="text" class="form-control" id="item_input-IdUoM" placeholder="UoM/Satuan. . ." autocomplete="off" value="<?= ($model->IdUoM? $model->itemUnit__r->UoM : '') ?>" <?= Yii::$app->controller->action->id == 'view'? 'readonly' : '' ?>>

                <input type="hidden" name="Item[IdUoM]" id="item_input-hidden-IdUoM" data-text='' value="<?= ($model->IdUoM? $model->IdUoM : '') ?>">
                <small id="item_input-hidden-IdUoM-error" class="text-danger d-none">
                    UoM tidak boleh kosong
                </small>      
            </div>
            <div class="form-group col-md-4 offset-md-1">
                <label class="font-weight-bold" for="item_input-ItemStock">Keterangan</label>
                <textarea class="form-control" id="item_input-Description" name="Item[Description]" rows=3 placeholder="Keterangan. . ." <?= Yii::$app->controller->action->id == 'view'? 'readonly' : '' ?>><?= ($model->Description? $model->Description : "") ?></textarea>
            </div>
        </div>

        <?php if(Yii::$app->controller->action->id == 'create'): ?>
            <div class="form-row">
                <div class="col-md-12 text-right">
                    <button type="buttom" class="btn btn-success" id="save_Item">Save</button>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- END FORM ITEM -->

<script>
    var actionId = '<?= Yii::$app->controller->action->id ?>'
</script>