<style>
	#form-sales-item td:nth-child(1){width: 5%;}
	#form-sales-item td:nth-child(2){width: 35%;}
	#form-sales-item td:nth-child(3){width: 30%;}
	#form-sales-item td:nth-child(4){width: 15%;}
	#form-sales-item td:nth-child(5){width: 15%;}
    .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {color: #ffffff;background-color: #17a2b8;border-color: #dee2e6 #dee2e6 #fff;}
</style>

<div class="card card-light mb-3" id="project-amount-container">
    <div class="card-header bg-info text-white p-2">
        <h4 class="card-title m-0">Item Project & Data Lainnya</h4>
    </div>
    <div class="card-body p-2">
    	<table class="table table-borderless" id="form-sales-item">
    		<thead>
    			<tr>
    				<th>#</th>
    				<th>Item</th>
    				<th>Qty</th>
    				<th>Harga</th>
    				<td></td>
    			</tr>
    		</thead>	
    		<tbody id="item-list">
    			
    		</tbody>
            <tbody>
                <tr>
                    <td>
                        <button id="btn-add-item" class="btn btn-warning">
                            <i class="fas fa-plus text-white"></i>
                        </button>
                    </td>
                    <td colspan=2></td>
                    <td>
                        <input class="form-control item_input-Total" placeholder="Total. . .">
                    </td>
                </tr>
            </tbody>
    	</table>
    </div>
</div>
<?php 
	$scriptDetailItem = "
		$(document).ready(function(){
			itemTypeaheadInit($('.item_input-ItemName'))
            createItemRow(0)
		})

		$('#btn-add-item').click(function(){
            var lastNumber = (typeof $('#item-list tr td:nth-child(1)').last().html() !== 'undefined'? parseInt($('#item-list tr td:nth-child(1)').last().html()) : 0)

            createItemRow(lastNumber)
        })

        $('body').on('keyup', '.item_input-ItemName', function(e){
            if(e.keyCode == 46 || e.keyCode == 8) {
                $(this).parents(`tr[id^='item_row-']`).find('.item_input-ItemName').typeahead('val', '')
                $(this).parents(`tr[id^='item_row-']`).find('.item_input-IdItem').val('')
                $(this).parents(`tr[id^='item_row-']`).find('.item_input-IdItem').attr('data-text', '')
                $(this).parents(`tr[id^='item_row-']`).find('.item_input-ItemUoM').text('-')
            }
        })

        $('body').on('typeahead:change', '.item_input-ItemName', function(ev, suggestion) {
            $(this).parents(`tr[id^='item_row-']`).find('.item_input-ItemName').typeahead(
                'val', 
                $(this).parents(`tr[id^='item_row-']`).find('.item_input-IdItem').attr('data-text')
            )
        })

        $('body').on('typeahead:select', '.item_input-ItemName', function(ev, suggestion) {
            if($('.item_input-IdItem[value='+suggestion.IdItem+']').length == 0){
                $(this).parents(`tr[id^='item_row-']`).find('.item_input-IdItem').val(suggestion.IdItem)
                $(this).parents(`tr[id^='item_row-']`).find('.item_input-IdItem').attr('value', suggestion.IdItem)
                $(this).parents(`tr[id^='item_row-']`).find('.item_input-IdItem').attr('data-text', suggestion.Name)
                $(this).parents(`tr[id^='item_row-']`).find('.item_input-ItemUoM').text(suggestion.UoM)
                $(this).parents(`tr[id^='item_row-']`).find('.item_input-Price').val(suggestion.Price)

                if(suggestion.StatusPrice == 0){
                    $(this).parents('tr').attr('style','background-color:#fdd8d8')
                }else{
                    $(this).parents('tr').removeAttr('style')
                }
            }else{
                alert('item sudah dipilih sebelumnya')
                $(this).parents(`tr[id^='item_row-']`).find('.item_input-ItemName').typeahead('val', '')
                $(this).parents(`tr[id^='item_row-']`).find('.item_input-IdItem').val('')
                $(this).parents(`tr[id^='item_row-']`).find('.item_input-IdItem').attr('data-text', '')
                $(this).parents(`tr[id^='item_row-']`).find('.item_input-ItemUoM').text('-')
            }
        })

		// ================== FUNCTION ==================
			function createItemRow(lastNumber, itemName = '', idItem = '', qty = '', price = ''){
                var itemContent = $(`<tr id='item_row-`+lastNumber+`'>
					    				<td>`+parseInt(lastNumber+1)+`</td>
					    				<td>
					    					<input class='form-control item_input-ItemName' name='ProjectItem[`+lastNumber+`][ItemName]' placeholder='Item. . .' value='`+itemName+`' data-text='`+itemName+`'>
					    					<input class='form-control item_input-IdItem' placeholder='this supposed to be hidden' name='ProjectItem[`+lastNumber+`][IdItem]' value=`+idItem+`>
					    				</td>
					    				<td>
					    					<div class='input-group mb-3'>
												<input class='form-control item_input-Qty' name='ProjectItem[`+lastNumber+`][Qty]' placeholder='Qty. . .' value=`+qty+`>
												<div class='input-group-append'>
													<span class='input-group-text item_input-ItemUoM'>-</span>
												</div>
											</div>
					    				</td>
					    				<td>
					    					<input class='form-control item_input-Price' name='ProjectItem[`+lastNumber+`][Price]' placeholder='Price. . .' value=`+price+`>
					    				</td>
					    				<td>
					    					<button type='button' class='btn btn-danger item_remove'>
				                                <i class='fas fa-times'></i>
				                            </button>
					    				</td>
					    			</tr>`)

                $('#form-sales-item #item-list').append(itemContent)

                itemTypeaheadInit($('#item_row-'+lastNumber+' .item_input-ItemName'))
            }

			function itemTypeaheadInit(inputTypeahead){
                var src = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    remote: {
                        url: '".Yii::$app->urlManager->createUrl('project/get-sales-item')."&q=%QUERY',
                        wildcard: '%QUERY'
                    }
                })

                inputTypeahead.typeahead(null, {
                    name: 'name',
                    display: 'Name',
                    source: src
                })
            }
        // ================== END FUNCTION ==================
	";

	$this->registerJs($scriptDetailItem, \yii\web\View::POS_END);
?>