<?php 
    $this->registerJsFile('@web/web/js/page_script/item/_form-supplier-item.js',['depends' => [\yii\web\JqueryAsset::class], 'defer' => 'defer']);
?>

<div class="card card-light mb-3" id="supplier-master-container">
    <div class="card-header bg-info text-white p-2">
        <h4 class="card-title m-0">Daftar Supplier</h4>
    </div>
    <div class="card-body p-2">
        <div class="form-row">
            <div class="col-md-4">
                <label class="font-weight-bold" for="supplieritem-search">Cari Data Berdasarkan:</label>
                <select class="form-control" id="supplieritem-search" name="item" multiple="multiple">
                    <option value="_allitem" selected="selected">Semua Item</option>
                    <?php foreach($model->supplierItem__r as $spi): ?>
                        <option value="<?= $spi->IdItem ?>"><?= $spi->item__r->Name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label>Total Stock</label>
                <input class="form-control item_stock-Stock" value="<?= $model->itemStock__r? $model->itemStock__r->Stock : '' ?>">
            </div>
        </div>
    
    <!-- DATA ITEM -->
        <div class="table-responsive">
            <hr>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr>
                        <th width="5%">#</th>
                        <th width="25%">Supplier</th>
                        <th width="20%">Stock</th>
                        <th width="20%">Harga Beli</th>
                        <th width="20%">Tgl Update</th>
                        <th width="10%">Actions</th>
                    </tr>
                </thead>
                <tbody id="supplier-item-list">
                    <?php 
                        $counter = 1;
                        foreach($model->supplierItem__r as $spi): ?>
                            <tr>
                                <td class="datatable_input-IdSpc" data-value="<?= $spi->Id ?>">
                                    <?= $counter ?>
                                </td>
                                <td class="datatable_input-Name" data-value="<?= $spi->item__r->Name ?>" editmode="true">
                                    <?= $spi->supplier__r->Name ?>
                                </td>
                                <td class="datatable_input-Stock" data-value="<?= $spi->Stock ?>" editmode="true">
                                    <?= $spi->Stock ?>
                                </td>
                                <td class="datatable_input-Price" data-value="<?= $spi->Price ?>" editmode="true">
                                    <?= Yii::$app->formatter->asDecimal($spi->Price, 0) ?>
                                </td>
                                <td class="datatable_input-CreatedAt" data-value="<?= $spi->LastUpdated ?>" editmode="true">
                                    <?= date("d-m-Y", strtotime($spi->LastUpdated)) ?>
                                </td>
                                <td class="datatable_input-ActionBtn" data-value="<?= $spi->Price ?>" editmode="true">
                                    <button class="btn btn-sm btn-success btn-submit d-none">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-sm btn-info btn-edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger btn-remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                            </tr>       
                    <?php 
                        $counter++; 
                        endforeach; 
                    ?>
                </tbody>
            </table>
        </div>
    <!-- END DATA ITEM -->
    </div>
</div>