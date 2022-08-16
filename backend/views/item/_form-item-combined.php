<?php 
    $this->registerJsFile('@web/web/js/page_script/item/_form-item-combined.js',['depends' => [\yii\web\JqueryAsset::class]]);
?>

<div class="card card-light mb-3" id="item-combined-container">
    <div class="card-header bg-info text-white p-2">
        <h4 class="card-title m-0">Item Combined</h4>
    </div>
    <div class="card-body p-2">
        <div class="form-row mb-4">
            <div class="col-md-6">
                <label class="font-weight-bold" for="itempart_input-ItemParent">Item Kombinasi</label>
                <input class="form-control bg-secondary text-white" id="itempart_input-ItemParentName" placeholder="Item Kombinasi. . .">
                <input type="hidden" class="form-control" id="itempart_input-ItemParentId" name="ItemCombined[IdItemParent]" data-text="">
            </div>
        </div>

        <hr>

    	<div class="form-row form-label">
    		<div class="col-md-1 text-center"><label class="font-weight-bold">#</label></div>
    		<div class="col-md-3"><label class="font-weight-bold">Nama Part</label></div>
            <div class="col-md-2"><label class="font-weight-bold">Jumlah Pembentuk</label></div>
            <div class="col-md-1"><label class="font-weight-bold">UoM</label></div>
    		<div class="col-md-4"><label class="font-weight-bold">Keterangan</label></div>
    	</div>
    	<div id="item-part-list">

        </div>
        <div class="form-row mt-4">
        	<div class="col-md-6">
        		<button class="btn btn-warning" id="btn-add-itempart"><i class="fas fa-plus text-white"></i></button>
        	</div>
            <div class="col-md-6 text-right">
                <button type="button" class="btn btn-success" id="save_ItemCombined">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    var selectedItemCombined
    var actionId = '<?= Yii::$app->controller->action->id ?>'        
</script>