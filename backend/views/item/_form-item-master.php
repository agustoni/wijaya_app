<div class="card card-light mb-3" id="item-master-container">
    <div class="card-header bg-info text-white p-2">
        <h4 class="card-title m-0">Item Master</h4>
    </div>
    <div class="card-body p-2">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label class="font-weight-bold" for="item_input-ItemName">Nama Barang</label>
                <input type="text" class="form-control" id="item_input-ItemName" placeholder="Nama Barang. . ." name="Item[Name]" value="<?= ($model->Name? $model->Name : '') ?>">
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

<?php 
    $scriptFormItemMaster = "
        var actionId = '".Yii::$app->controller->action->id."'

        // ================== AUTOCOMPLETE UoM ==================
            $('body').on('keyup', '#item_input-IdUoM', function(e){
                if($('#item_input-IdUoM').parents('.twitter-typeahead').length == 0){
                    $('#item_input-hidden-NewUoM').val($(this).val())
                }else{
                    if(e.keyCode == 46 || e.keyCode == 8) {
                        $('#item_input-IdUoM').typeahead('val','')
                        $('#item_input-hidden-IdUoM').val('')
                        $('#item_input-hidden-IdUoM').attr('data-text', '')
                    }
                }   
            })

            $('#item_input-IdUoM').bind('typeahead:select', function(ev, suggestion) {
                if($('#item_input-IdUoM').parents('.twitter-typeahead').length != 0){
                    $('#item_input-hidden-IdUoM').val(suggestion.Id)
                    $('#item_input-hidden-IdUoM').attr('data-text', suggestion.UoM)
                }
            })

            $('#item_input-IdUoM').bind('typeahead:change', function(ev, suggestion) {
                $('#item_input-IdUoM').typeahead('val', $('#item_input-hidden-IdUoM').attr('data-text'))
            })

            $('.toggle-search-uom').click(function(){
                var child = $(this).children()
                if(child.attr('class') == 'fas fa-toggle-on'){
                    child.attr('class', 'fas fa-toggle-off')

                    $('#item_input-IdUoM').typeahead('destroy')
                }else if(child.attr('class') == 'fas fa-toggle-off'){
                    child.attr('class', 'fas fa-toggle-on')

                    var src = new Bloodhound({
                        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                        queryTokenizer: Bloodhound.tokenizers.whitespace,
                        remote: {
                            url: '".Yii::$app->urlManager->createUrl('item/get-uom')."&q=%QUERY',
                            wildcard: '%QUERY'
                        }
                    })

                    $('#item_input-IdUoM').typeahead(null, {
                        name: 'uom',
                        display: 'UoM',
                        source: src
                    })
                }

                $('#item_input-IdUoM').val('')
                $('#item_input-hidden-NewUoM').val('')
                $('#item_input-hidden-IdUoM').val('')
            })
        // ================== END AUTOCOMPLETE UoM ==================

        // ================== SAVE VALIDATION ==================
            $('#save_Item').on('click',function(e){
                var validation = true

                if($('#item_input-hidden-IdUoM').val() == '' && $('#item_input-hidden-NewUoM').val() == ''){
                    validation = false

                    if($('.toggle-search-uom').find('i').hasClass('fa-toggle-on')){
                        $('#item_input-hidden-IdUoM-error').removeClass('d-none')
                    }else{
                        $('#item_input-hidden-NewUoM-error').removeClass('d-none')
                    }
                }else{
                    $('#item_input-hidden-IdUoM-error').addClass('d-none')
                    $('#item_input-hidden-NewUoM-error').addClass('d-none')
                }

                if(!$('#item_input-ItemName').val()){
                    validation = false
                    var errorLabel = $(`<small class='text-danger error-label'>
                                            Nama item belum diisi
                                        </small>`)
                    $('#item_input-ItemName').after(errorLabel)
                }else{
                    $('#item_input-ItemName').parents('div').find('.error-label').remove()
                }

                if(!$('#item_input-ItemType').val()){
                    validation = false
                    var errorLabel = $(`<small class='text-danger error-label'>
                                            Tipe item belum diisi
                                        </small>`)
                    $('#item_input-ItemType').after(errorLabel)
                }else{
                    $('#item_input-ItemType').parents('div').find('.error-label').remove()
                }

                if(validation && confirm('Simpan data master item?')){
                    var data = $('#item-master-container .card-body :input').serializeArray()

                    $.ajax({
                        type: 'POST',
                        url: urlSaveItem,
                        data: data,
                        dataType:'json',
                        async: true,
                        beforeSend: function() {
                            $('#layoutSidenav_content').busyLoad('show', {spinner: 'cube',text: 'loading'})
                        },
                        success: function(d){
                            if(!d.success){
                                alert(d.messages)
                            }else{
                                if(actionId == 'view'){
                                    alert('data berhasil diperbaharui')
                                    location.reload()
                                }else if(actionId == 'create'){
                                    alert('data berhasil dimasukan')
                                    $('#item-master-container .card-body :input').val('')
                                }
                            }
                        },
                    }).complete(function(d){
                        $('#layoutSidenav_content').busyLoad('hide')
                    })
                }
            })
        // ================== SAVE VALIDATION ==================

        // ================== FUNCTION ==================
            
        // ================== END FUNCTION ==================
    ";
    $this->registerJs($scriptFormItemMaster, \yii\web\View::POS_END);
?>