<?php 
    $this->registerJsFile('@web/web/js/page_script/item/_form-item.js',['depends' => [\yii\web\JqueryAsset::class]]);
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
<div class="card card-light mb-3" id="item-master-container">
    <div class="card-header bg-info text-white p-2">
        <h4 class="card-title m-0">Item Master</h4>
    </div>
    <div class="card-body p-2">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label class="font-weight-bold" for="item_input-ItemName">Nama Barang</label>
                <input type="text" class="form-control" id="item_input-ItemName" placeholder="Nama Barang. . ." name="Item[Name]" value="<?= ($model->Name? $model->Name : '') ?>" data-iditem="<?= $model->Id? $model->Id : null ?>">
            </div>
            <div class="form-group col-md-4 offset-md-1">
                <label class="font-weight-bold" for="item_input-ItemType">Jenis</label>
                <?php if($model->Type && $model->Type == 2){ ?>
                    <input type="hidden" name="Item[Type]" id="item_input-ItemType" value="<?= $model->Type ?>">
                    <br> <?= $model->itemType[$model->Type] ?>
                <?php }else{ ?>
                    <select class="form-control" id="item_input-ItemType" name="Item[Type]">
                        <option value="">- Select Type -</option>
                        <?php foreach($model->itemType as $idType => $ty): ?>
                            <option value="<?= $idType ?>" <?= $model->Type == $idType? "selected" : "" ?>><?= $ty ?></option>
                        <?php endforeach ?>
                    </select>
                <?php } ?>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <label class="font-weight-bold" for="item_input-IdUoM">UoM</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="item_input-IdUoM" placeholder="UoM/Satuan. . ." autocomplete="off" value="<?= ($model->IdUoM? $model->itemUnit__r->UoM : '') ?>">
                    <div class="input-group-append">
                        <span class="input-group-text toggle-search-uom">
                            <i class="fas fa-toggle-off"></i>
                        </span>
                    </div>
                </div>

                <input type="hidden" name="Item[IdUoM]" id="item_input-hidden-IdUoM" data-text='' value="<?= ($model->IdUoM? $model->IdUoM : '') ?>">
                <small id="item_input-hidden-IdUoM-error" class="text-danger d-none">
                    UoM yang dipilih tidak terdaftar/UoM belum dipilih
                </small>      

                <input type="hidden" name="Item[NewUoM]" id="item_input-hidden-NewUoM">
                <small id="item_input-hidden-NewUoM-error" class="text-danger d-none">
                    UoM tidak boleh kosong
                </small>      
            </div>
            <div class="form-group col-md-4 offset-md-1">
                <label class="font-weight-bold" for="item_input-ItemStock">Keterangan</label>
                <!-- <input type="number" class="form-control" id="item_input-ItemStock" placeholder="Stock. . ." name="Item[Stock]"> -->
                <textarea class="form-control" id="item_input-Description" name="Item[Description]" rows=3 placeholder="Keterangan. . ."><?= ($model->Description? $model->Description : "") ?></textarea>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-12 text-right">
                <button type="buttom" class="btn btn-success" id="save_Item">Save</button>
            </div>
        </div>
    </div>
</div>
<script>
    var actionId = '<?= Yii::$app->controller->action->id ?>'
</script>