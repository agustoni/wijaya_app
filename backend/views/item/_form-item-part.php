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
            <div class="col-md-1"><label class="font-weight-bold">UoM</label></div>
    		<div class="col-md-2"><label class="font-weight-bold">Jumlah Pembentuk</label></div>
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

<?PHP 
    $script = "
        var selectedItemCombined
        var actionId = '".Yii::$app->controller->action->id."'        
        
        $(document).ready(function(){
            if(actionId == 'view'){
                $('#itempart_input-ItemParentName').parents('.form-row').addClass('d-none')
                $('#itempart_input-ItemParentId').val(dataItemPart[0].Id)
                $('#itempart_input-ItemParentId').attr('data-text', dataItemPart[0].Name)
                createItemPart(dataItemPart[0])

            }else{
                itemParentTypeaheadInit()
            }
        })

        // ================== SAVE VALIDATION ==================
            $('body').on('click', '#save_ItemCombined', function(){
                var validate = true
                var dataCount = 0
                
                var data = new FormData()

                $('div[id^=itempart_row-]').each(function(x){
                    var idItem = $(this).find('.itempart_input-IdItem').val()
                    var qty = $(this).find('.itempart_input-Qty').val()
                    var desc = $(this).find('.itempart_input-Description').val()
                    var idItemPart = $(this).find('.itempart_input-IdItemPart').val()

                    if(idItem || qty){
                        if(!idItem || !qty){
                            validate = false

                            return false
                        }else if(idItem && qty){
                            data.append('ItemPart['+x+'][Qty]', qty)
                            data.append('ItemPart['+x+'][IdItem]', idItem)
                            data.append('ItemPart['+x+'][Description]', desc)
                            data.append('ItemPart['+x+'][IdItemPart]', idItemPart)

                            dataCount++
                        }
                    }
                })

                if(validate && !$('#itempart_input-ItemParentId').val()){
                    validate = false
                }else{
                    data.append('IdItemParent', $('#itempart_input-ItemParentId').val())
                }

                if(validate && dataCount == 0){
                    validate = false
                }

                if(validate){
                    if(confirm('Apakah Anda yakin?')){
                        $.ajax({
                            type: 'POST',
                            url: '".Yii::$app->urlManager->createUrl("item/save-item-combined")."',
                            data: data,
                            contentType: false,
                            cache: false,
                            processData: false,
                            dataType:'json',
                            async: true,
                            beforeSend: function() {
                                $('#layoutSidenav_content').busyLoad('show', {spinner: 'cube',text: 'loading'})
                            },
                            success: function(d){
                                if(!d.success){
                                    alert(d.messages)
                                }else{
                                    alert('Data berhasil di-update')
                                }
                            },
                        }).complete(function(d){
                            // itemParentTypeaheadInit()
                            $('#layoutSidenav_content').busyLoad('hide')
                        })
                    }
                }else{
                    alert('data yang dimasukan tidak lengkap')                 
                }
            })
        // ================== END SAVE VALIDATION ==================

        // ================== FUNCTION ==================
            // ---------------- TYPEAHEAD ITEM PART ----------------
                $('body').on('typeahead:select', '.itempart_input-ItemName', function(ev, suggestion) {
                    if($('.itempart_input-IdItem[value='+suggestion.Id+']').length == 0){
                        $(this).parents(`div[id^='itempart_row-']`).find('.itempart_input-IdItem').val(suggestion.Id)
                        $(this).parents(`div[id^='itempart_row-']`).find('.itempart_input-IdItem').attr('data-text', suggestion.Name)
                        $(this).parents(`div[id^='itempart_row-']`).find('.itempart_input-ItemUoM').text(suggestion.UoM)
                    }else{
                        alert('item sudah dipilih sebelumnya')
                        $(this).parents(`div[id^='itempart_row-']`).find('.itempart_input-ItemName').typeahead('val', '')
                        $(this).parents(`div[id^='itempart_row-']`).find('.itempart_input-IdItem').val('')
                        $(this).parents(`div[id^='itempart_row-']`).find('.itempart_input-IdItem').attr('data-text', '')
                        $(this).parents(`div[id^='itempart_row-']`).find('.itempart_input-ItemUoM').text('-')
                    }
                })

                $('body').on('typeahead:change', '.itempart_input-ItemName', function(ev, suggestion) {
                    $(this).parents(`div[id^='itempart_row-']`).find('.itempart_input-ItemName').typeahead(
                        'val', 
                        $(this).parents(`div[id^='itempart_row-']`).find('.itempart_input-IdItem').attr('data-text')
                    )
                })

                $('body').on('keyup', '.itempart_input-ItemName', function(e){
                    if(e.keyCode == 46 || e.keyCode == 8) {
                        $(this).parents(`div[id^='itempart_row-']`).find('.itempart_input-ItemName').typeahead('val', '')
                        $(this).parents(`div[id^='itempart_row-']`).find('.itempart_input-IdItem').val('')
                        $(this).parents(`div[id^='itempart_row-']`).find('.itempart_input-IdItem').attr('data-text', '')
                        $(this).parents(`div[id^='itempart_row-']`).find('.itempart_input-ItemUoM').text('-')
                    }
                })

                $('#btn-add-itempart').click(function(){
                    var lastNumber = (typeof $('#item-part-list div:nth-child(1) label').last().html() !== 'undefined'? parseInt($('#item-part-list div:nth-child(1) label').last().html()) : 0)

                    createItemPartRow(lastNumber)
                })

                $('body').on('click', '.itempart_remove-item', function(){
                    var idItemPart = $(this).parents('div[id^=itempart_row-]').find('.itempart_input-IdItemPart').val()
                    
                    if(!idItemPart){
                        removeItemPartRow($(this))    
                    }else{
                        // delete data if exist
                        if(confirm('Apakah Anda yakin?')){
                            deleteItemPart(idItemPart, $(this))
                        }
                    }
                })

                function deleteItemPart(idItemPart, el){
                    $.ajax({
                        type: 'POST',
                        url: '".Yii::$app->urlManager->createUrl("item/delete-part-combined")."',
                        data: {idItemPart},
                        dataType:'json',
                        async: true,
                        beforeSend: function() {
                            $('#layoutSidenav_content').busyLoad('show', {spinner: 'cube',text: 'loading'})
                        },
                        success: function(d){
                            if(!d.success){
                                alert(d.messages)
                            }else{
                                alert('Data berhasil dihapus')
                            }
                        },
                    }).complete(function(d){
                        // itemParentTypeaheadInit()
                        removeItemPartRow(el)
                        $('#layoutSidenav_content').busyLoad('hide')
                    })
                }

                function removeItemPartRow(el){
                    if($(el).parents('#item-part-list').find(`div[id^='itempart_row-']`).length > 1){
                        $(el).parents(`div[id^='itempart_row-']`).remove()
                    }else{
                        $(el).parents(`div[id^='itempart_row-']`).find(':input').val('')
                    }

                    $('#item-part-list').find(`div[id^='itempart_row-']`).each(function(x){
                        $(this).find('div:nth-child(1) label').html(parseInt(x)+1)
                        $(this).attr('id', 'itempart_row-'+x)

                        $(this).find(`:input[name^='ItemCombined[ItemPart]']`).each(function(){
                            var name = $(this).attr('name').split(/[[\]]{1,2}/)
                            
                            $(this).attr('name', 'ItemCombined[ItemPart]['+x+']['+name[3]+']')
                        })
                    })
                }

                function createItemPartRow(lastNumber, itemName = '', idItem = '', qty = '', uom = '', description = '', idItemPart = ''){
                    var itemPartContent = $(`<div class='form-row mb-2' id='itempart_row-`+lastNumber+`'>
                                                <div class='col-md-1 my-auto text-center'>
                                                    <label class='font-weight-bold'>`+(lastNumber + 1)+`</label>
                                                </div>
                                                <div class='col-md-3 my-auto'>
                                                    <!-- <div class='input-group'> -->
                                                        <input type='text' class='form-control itempart_input-ItemName' placeholder='Item. . .' autocomplete='off' value='`+itemName+`'>
                                                        <!-- <div class='input-group-append'>
                                                            <button class='btn btn-info' type='button' data-toggle='modal' data-target='#modal-create-itempart'><i class='fas fa-plus'></i></button>
                                                        </div> -->
                                                    <!-- </div> -->
                                                    <input type='hidden' class='form-control itempart_input-IdItem' name='ItemCombined[ItemPart][`+lastNumber+`][IdItem]' data-text='' value='`+idItem+`'>
                                                    <input type='hidden' class='form-control itempart_input-IdItemPart' name='ItemCombined[ItemPart][`+lastNumber+`][IdItemPart]' data-text='' value='`+idItemPart+`'>
                                                </div>
                                                <div class='col-md-1 my-auto'>
                                                    <span class='itempart_input-ItemUoM'>`+(uom != ''? uom : '-')+`</span>
                                                </div>
                                                <div class='col-md-2 my-auto'>
                                                    <input type='number' class='form-control itempart_input-Qty' name='ItemCombined[ItemPart][`+lastNumber+`][Qty]' placeholder='Qty. . .' value='`+qty+`'>
                                                </div>
                                                <div class='col-md-4 my-auto'>
                                                    <textarea class='form-control itempart_input-Description' name='ItemCombined[ItemPart][`+lastNumber+`][Description]' placeholder='Keterangan. . . (optional)'>`+description+`</textarea>
                                                </div>
                                                <div class='col-md-1 my-auto text-center'>
                                                    <button type='button' class='btn btn-danger itempart_remove-item'>
                                                        <i class='fas fa-times'></i>
                                                    </button>
                                                </div>
                                            </div>`)

                    $('#item-part-list').append(itemPartContent)

                    itemPartTypeaheadInit($('#itempart_row-'+lastNumber+' .itempart_input-ItemName'))
                }

                function itemPartTypeaheadInit(inputTypeahead){
                    var src = new Bloodhound({
                        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                        queryTokenizer: Bloodhound.tokenizers.whitespace,
                        remote: {
                            url: '".Yii::$app->urlManager->createUrl('item/get-all-item')."&q=%QUERY',
                            wildcard: '%QUERY'
                        }
                    })

                    inputTypeahead.typeahead(null, {
                        name: 'name',
                        display: 'Name',
                        source: src
                    })
                }
            // ---------------- END TYPEAHEAD ITEM PART ----------------

            // ---------------- TYPEAHEAD ITEM PARENT ----------------
                // itemParentTypeaheadInit()

                $('body').on('typeahead:select', '#itempart_input-ItemParentName', function(ev, suggestion) {
                    $('#itempart_input-ItemParentId').val(suggestion.Id)
                    $('#itempart_input-ItemParentId').attr('data-text', suggestion.Name)

                    $('#item-part-list').empty()

                    createItemPart(suggestion)
                })

                $('body').on('typeahead:change', '#itempart_input-ItemParentName', function(ev, suggestion) {
                    $(this).typeahead(
                        'val', 
                        $('#itempart_input-ItemParentId').attr('data-text')
                    )
                })

                $('body').on('keyup', '#itempart_input-ItemParentName', function(e){
                    if(e.keyCode == 46 || e.keyCode == 8) {
                        $('#itempart_input-ItemParentName').typeahead('val', '')
                        $('#itempart_input-ItemParentId').val('')
                        $('#itempart_input-ItemParentId').attr('data-text', '')
                    }
                })

                function createItemPart(suggestion){
                    selectedItemCombined = suggestion.ItemPart

                    if(selectedItemCombined.length > 0){
                        $(suggestion.ItemPart).each(function(x, part){
                            var description = (part['Description'] == null)? '' : part['Description']
                                
                            createItemPartRow(x, part['Part'], part['Id'], part['Qty'], part['UoM'], description, part['IdItemPart'])
                        })
                    }else{
                        createItemPartRow(0)
                    }
                }

                function itemParentTypeaheadInit(){
                    var src = new Bloodhound({
                        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                        queryTokenizer: Bloodhound.tokenizers.whitespace,
                        remote: {
                            url: '".Yii::$app->urlManager->createUrl('item/get-all-item-parent')."&q=%QUERY',
                            wildcard: '%QUERY'
                        }
                    })

                    $('#itempart_input-ItemParentName').typeahead(null, {
                        name: 'name',
                        display: 'Name',
                        source: src
                    }) 
                }
            // ---------------- END TYPEAHEAD ITEM PARENT ----------------
        // ================== END FUNCTION ==================
    ";

    $this->registerJs($script, \yii\web\View::POS_END);
?>