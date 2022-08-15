<div id="form-item-wrapper">
	<?php //$form = ActiveForm::begin(['id' => 'form-item-regulation']); ?>
	<!-- ITEM MASTER -->
	<div class="card card-light mb-3" id="item-master-container">
        <div class="card-header bg-info text-white p-2">
            <h4 class="card-title m-0">Item Master</h4>
        </div>
        <div class="card-body p-2">
			<div class="form-row">
				<div class="form-group col-md-4">
					<label class="font-weight-bold" for="item_input-ItemName">Item</label>
					<input type="text" class="form-control" id="item_input-ItemName" placeholder="Item. . ." name="Item[Name]">
				</div>
				<div class="form-group col-md-4 offset-md-1">
					<label class="font-weight-bold" for="item_input-ItemType">Type</label>
					<select class="form-control" id="item_input-ItemType" name="Item[Type]">
						<option value="">- Select Type -</option>
						<?php foreach($model->itemType as $idType => $ty): ?>
							<option value="<?= $idType ?>"><?= $ty ?></option>
						<?php endforeach ?>
					</select>
				</div>
			</div>

			<div class="form-row">
				<div class="form-group col-md-4">
					<label class="font-weight-bold" for="item_input-IdUoM">UoM</label>
					<div class="input-group">
						<input type="text" class="form-control" id="item_input-IdUoM" placeholder="UoM. . ." autocomplete="off">
						<div class="input-group-append">
			                <span class="input-group-text toggle-search-uom">
			                    <i class="fas fa-toggle-off"></i>
			                </span>
			            </div>
					</div>

					<input type="hidden" name="Item[IdUoM]" id="item_input-hidden-IdUoM" data-text=''>
					<small id="item_input-hidden-IdUoM-error" class="text-danger d-none">
		          		UoM yang dipilih tidak terdaftar/UoM belum dipilih
			        </small>      

					<input type="hidden" name="Item[NewUoM]" id="item_input-hidden-NewUoM">
					<small id="item_input-hidden-NewUoM-error" class="text-danger d-none">
		          		UoM tidak boleh kosong
			        </small>      
				</div>
				<div class="form-group col-md-4 offset-md-1">
					<label class="font-weight-bold" for="item_input-ItemStock">Stock</label>
					<input type="number" class="form-control" id="item_input-ItemStock" placeholder="Stock. . ." name="Item[Stock]">
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-12 text-right">
					<button type="buttom" class="btn btn-success" id="save_Item">Save</button>
				</div>
			</div>
		</div>
	</div>
	<!-- END ITEM MASTER -->
	<?php //ActiveForm::end(); ?>

	<!-- ITEM PART -->
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
    <!-- END ITEM PART -->
</div>

<?php
    $script="
    	// ################## AUTOCOMPLETE UoM ##################
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
        // ################## END AUTOCOMPLETE UoM ##################

        // ################## SAVE VALIDATION ##################
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
                    console.log('item type kosong')

                    validation = false
                    var errorLabel = $(`<small class='text-danger error-label'>
                                            Tipe item belum diisi
                                        </small>`)
                    $('#item_input-ItemType').after(errorLabel)
                }else{
                    $('#item_input-ItemType').parents('div').find('.error-label').remove()
                }

                if(!$('#item_input-ItemStock').val()){
                    validation = false
                    var errorLabel = $(`<small class='text-danger error-label'>
                                            Stock item belum diisi
                                        </small>`)
                    $('#item_input-ItemStock').after(errorLabel)
                }else{
                    $('#item_input-ItemStock').parents('div').find('.error-label').remove()
                }

                if(validation && confirm('Simpan data master item')){
                    var data = $('#item-master-container .card-body :input').serializeArray()

                    $.ajax({
                        type: 'POST',
                        url: '".Yii::$app->urlManager->createUrl("item/save-item")."',
                        data: data,
                        dataType:'json',
                        async: true,
                        beforeSend: function() {
                            $('body').busyLoad('show', {spinner: 'cube',text: 'loading'})
                        },
                        success: function(d){
                            console.log(d)
                            if(!d.success){
                                alert(d.messages)
                            }else{
                                $('#item-master-container .card-body :input').val('')
                            }
                        },
                    }).done(function(d){
                        $('body').busyLoad('hide')
                    })
                }
            })

            $('#save_ItemCombined').on('click', function(){
                var validate = true
                var dataCount = 0
                
                var data = new FormData();

                $('div[id^=itempart_row-]').each(function(x){
                    var idItem = $(this).find('.itempart_input-IdItem').val()
                    var qty = $(this).find('.itempart_input-Qty').val()
                    var desc = $(this).find('.itempart_input-Description').val()

                    if(idItem || qty){
                        if(!idItem || !qty){
                            console.log('part')

                            return false
                        }else if(idItem && qty){
                            data.append('ItemPart['+x+'][Qty]', qty);
                            data.append('ItemPart['+x+'][IdItem]', idItem);
                            data.append('ItemPart['+x+'][Description]', desc);

                            dataCount++;
                        }
                    }
                })

                if(validate && !$('#itempart_input-ItemParentId').val()){
                    validate = false
                }else{
                    data.append('IdItemParent', $('#itempart_input-ItemParentId').val());
                }

                if(validate && dataCount == 0){
                    validate = false
                }

                if(validate){
                    if(confirm('Apakah Anda yakin?')){
                        // var data = $('#item-combined-container .card-body :input').serializeArray()

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
                                $('body').busyLoad('show', {spinner: 'cube',text: 'loading'})
                            },
                            success: function(d){
                                console.log(d)
                                if(!d.success){
                                    alert(d.messages)
                                }else{
                                    alert('Data berhasil diinput')
                                }
                            },
                        }).done(function(d){
                            $('body').busyLoad('hide')
                        })
                    }
                }else{
                    alert('data yang dimasukan tidak lengkap')                 
                }
            })
        // ################## END SAVE VALIDATION ##################

        // ################## FUNCTION ITEM PART ##################
            // $('#item_input-ItemType').change(function(){
            //     if($(this).val() == 2){
            //         $('#item-part-container').removeClass('d-none')
            //     }else{
            //         $('#item-part-container').addClass('d-none')
            //     }
            // })

            // ----------------------------------- ITEM PARENT -----------------------------------
                itemParentTypeaheadInit()

                $('body').on('typeahead:select', '#itempart_input-ItemParentName', function(ev, suggestion) {
                    $('#itempart_input-ItemParentId').val(suggestion.Id)
                    $('#itempart_input-ItemParentId').attr('data-text', suggestion.Name)
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
            // ----------------------------------- END ITEM PARENT -----------------------------------

            // ----------------------------------- ITEM PART -----------------------------------
                $('body').on('typeahead:select', '.itempart_input-ItemName', function(ev, suggestion) {
                    $(this).parents(`div[id^='itempart_row-']`).find('.itempart_input-IdItem').val(suggestion.Id)
                    $(this).parents(`div[id^='itempart_row-']`).find('.itempart_input-IdItem').attr('data-text', suggestion.Name)
                    $(this).parents(`div[id^='itempart_row-']`).find('.itempart_input-ItemUoM').text(suggestion.UoM)
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
                    if($(this).parents('#item-part-list').find(`div[id^='itempart_row-']`).length > 1){
                        $(this).parents(`div[id^='itempart_row-']`).remove()
                    }else{
                        $(this).parents(`div[id^='itempart_row-']`).find(':input').val('')
                    }

                    $('#item-part-list').find(`div[id^='itempart_row-']`).each(function(x){
                        $(this).find('div:nth-child(1) label').html(parseInt(x)+1)
                        $(this).attr('id', 'itempart_row-'+x)

                        $(this).find(`:input[name^='ItemCombined[ItemPart]']`).each(function(){
                            var name = $(this).attr('name').split(/[[\]]{1,2}/)
                            
                            $(this).attr('name', 'ItemCombined[ItemPart]['+x+']['+name[3]+']')
                        })
                    })
                })

                function createItemPartRow(lastNumber){
                    var itemPartContent = $(`<div class='form-row mb-2' id='itempart_row-`+lastNumber+`'>
                                                <div class='col-md-1 my-auto text-center'>
                                                    <label class='font-weight-bold'>`+(lastNumber + 1)+`</label>
                                                </div>
                                                <div class='col-md-3 my-auto'>
                                                    <!-- <div class='input-group'> -->
                                                        <input type='text' class='form-control itempart_input-ItemName' placeholder='Item. . .' autocomplete='off'>
                                                        <!-- <div class='input-group-append'>
                                                            <button class='btn btn-info' type='button' data-toggle='modal' data-target='#modal-create-itempart'><i class='fas fa-plus'></i></button>
                                                        </div> -->
                                                    <!-- </div> -->
                                                    <input type='hidden' class='form-control itempart_input-IdItem' name='ItemCombined[ItemPart][`+lastNumber+`][IdItem]' data-text=''>
                                                </div>
                                                <div class='col-md-1 my-auto'>
                                                    <span class='itempart_input-ItemUoM'>-</span>
                                                </div>
                                                <div class='col-md-2 my-auto'>
                                                    <input type='number' class='form-control itempart_input-Qty' name='ItemCombined[ItemPart][`+lastNumber+`][Qty]' placeholder='Qty. . .'>
                                                </div>
                                                <div class='col-md-4 my-auto'>
                                                    <textarea class='form-control itempart_input-Description' name='ItemCombined[ItemPart][`+lastNumber+`][Description]' placeholder='Keterangan. . . (optional)'></textarea>
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
            // ----------------------------------- END ITEM PART -----------------------------------
        // ################## END FUNCTION ITEM PART ##################

        // ################## DATA TABLE ##################
            // $.fn.dataTable.moment( 'MMM D, Y' )
            
            // $('#dataSupplierItem').DataTable({
            //     'columnDefs': [
            //         {'orderable': true, 'targets': 3 }
            //       ],
            //     'aaSorting': []
            // })

            // $('.toggle-search-client').click(function(){
            //     var child = $(this).children()
            //     if(child.attr('class') == 'fas fa-toggle-on'){
            //         child.attr('class', 'fas fa-toggle-off')
            //     }else if(child.attr('class') == 'fas fa-toggle-off'){
            //         child.attr('class', 'fas fa-toggle-on')
            //     }
            // })
        // ################## END DATA TABLE ##################
    ";

    $this->registerJs($script, \yii\web\View::POS_END);
?>