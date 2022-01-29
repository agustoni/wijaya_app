<?php 
    $this->registerCssFile("https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css", [
        'depends'=> [
            \yii\bootstrap4\BootstrapAsset::className()
        ]
    ]);

    $this->registerJsFile("https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js",[
        'depends' => [
            \yii\web\JqueryAsset::className()
        ],
        'position' => \yii\web\View::POS_END
    ]);
?>
<style>
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

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<div class="card card-light mb-3" id="project-amount-container">
    <div class="card-header bg-info text-white p-2">
        <h4 class="card-title m-0">Item Project & Data Lainnya</h4>
    </div>
    <div class="card-body p-2">
        <div class="row">
            <div class="col-md-8">
                <label class="font-weight-bold">Tambah Product</label>
                <select class="form-control col-md-12 select2-product-input" style="width: 100% !important"></select>
            </div>
        </div>
        <hr>

    	<!-- <table class="table table-borderless table-sm" id="form-sales-item">
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
                    <td class="text-right" colspan="2">
                        <b>Total Modal</b>
                    </td>
                    <td class="text-right">
                        <label class="item_label-TotalCost"></label>
                        <input type="hidden" class="form-control item_input-TotalCost" placeholder="Total Modal. . .">
                    </td>
                    
                </tr>
                <tr style="background-color:#eee">
                    <td class="text-right" colspan="3">
                        <b>Margin</b>
                    </td>
                    <td class="text-right">
                        <div class="input-group mb-3 btn-margin-type d-none">
                            <div class="input-group-prepend">
                                <button class="btn btn-secondary btn-margin-type" data-type="nominal">
                                    Num
                                </button>
                            </div>
                        </div>
                        <div class="input-group mb-3 btn-margin-type">
                            <div class="input-group-prepend">
                                <button class="btn btn-secondary btn-margin-type" data-type="persen">
                                    %
                                </button>
                                <input class="form-control item_input-MarginPercent" >
                            </div>
                        </div>
                        <input type="" class="form-control item_input-MarginNominal text-right" placeholder="Margin. . .">
                    </td>
                </tr>
                <tr style="background-color:#eee">
                    <td class="text-right" colspan="3">
                        <b>Grand Total</b>
                    </td>
                    <td class="text-right">
                        <label class="item_GrandTotal-label"></label>
                        <input type="hidden" class="form-control item_input-GrandTotal" placeholder="Grand Total. . .">
                    </td>
                </tr>
            </tbody>
    	</table> -->

        <!-- ================================================================= --> 
        <div id="form-project-product">
            <ul class="nav nav-tabs" role="tablist">
                <!-- <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#product_1">Product 1</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#product_2">Product 2</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#product_3">Product 3</a>
                </li> -->
            </ul>
            <div class="tab-content">
                <!-- <div id="product_1" class="tab-pane active"><br>
                    <h3 class='product_label-ProductName'>LIFT ACX-BR3</h3>

                    <table class='table table-borderless table-sm table-product-item'>
                        <thead>
                            <th>#</th>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Deskripsi</th>
                            <th>Total</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <tr>
                                <td class='align-middle'>1</td>
                                <td class='align-middle'>
                                    <label class='product_label-Item'>Item 1</label>
                                    <input type='text' class='form-control product_input-IdItem' placeholder='supposed to be hidden'>
                                </td>
                                <td  class='align-middle'>
                                    <input type='number' class='form-control product-input-Qty'>
                                </td>
                                <td  class='align-middle'>
                                    <textarea class='form-control product_input-Description' rows='3'></textarea>
                                </td>
                                <td  class='align-middle'>
                                    <label class='product_label-Price'>Rp 123.123.123</label>
                                    <input type='text' class='form-control product_input-Price' placeholder='supposed to be hidden'>
                                </td>
                                <td  class='align-middle'>
                                    <button type='button' class='btn btn-danger product_removeitem'>
                                        <i class='fas fa-times'></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="product_2" class="container tab-pane fade"><br>
                    <h3>Menu 1</h3>
                    <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
                <div id="product_3" class="container tab-pane fade"><br>
                    <h3>Menu 2</h3>
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
                </div> -->
            </div>
        </div>
    </div>
</div>
<?php 
	$scriptDetailItem = "
		$(document).ready(function(){
			itemTypeaheadInit($('.item_input-ItemName'))
            // createItemRow(0)
		})

        // ===================== SELECT 2 PRODUCT =====================
            $('.select2-product-input').select2({
                ajax: {
                    url: '".Yii::$app->urlManager->createUrl("project/get-all-product")."',
                    dataType: 'json',
                    processResults: function (data) {
                        return {
                            results: data
                        }
                    }
                }
            })

            $('.select2-product-input').on('select2:select', function (e) {
                var selected = e.params.data
                console.log(selected)
                // if($('.itemlist_input-IdItem').length == 0 || $('.itemlist_input-IdItem[value='+selected.id+']').length == 0){
                //     createItemList(selected.id, selected.text)
                // }else{
                //     alert(selected.text+' sudah ada dalam list product')
                // }

                $('.select2-product-input').val(null).trigger('change')

                createProduct(selected)
            })

            function createProduct(data){
                var x = $('#form-project-product .nav-tabs li').length
                var productName = 'Produk '+(parseInt(x)+1)
                var tab = $(`<li class='nav-item'>
                                <a class='nav-link `+(x == 0? 'active' : '')+`' data-toggle='tab' href='#product_`+x+`'>`+productName+`</a>
                            </li>`)

                var tabContent = $(`<div id='product_`+x+`' class='tab-pane `+(x == 0? 'active' : '')+`'>
                                        <h3 class='product_label-ProductName'>`+data.text+`</h3>
                                        <table class='table table-borderless table-sm table-product-item'>
                                            <thead>
                                                <th>#</th>
                                                <th>Item</th>
                                                <th>Qty</th>
                                                <th>UoM</th>
                                                <th>Deskripsi</th>
                                                <th>Total</th>
                                                <th></th>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                    </div>`)

                $(data.listitem).each(function(i, val){
                    var tabContentItem = $(`<tr>
                                                <td class='align-middle'>`+(parseInt(i)+1)+`</td>
                                                <td class='align-middle'>
                                                    <label class='product_label-Item'>`+val.ItemName+`</label>
                                                    <input type='text' class='form-control product_input-IdItem' value='`+val.IdItem+`' placeholder='supposed to be hidden'>
                                                </td>
                                                <td  class='align-middle'>
                                                    <input type='number' class='form-control product-input-Qty' value='`+val.Qty+`'>
                                                </td>
                                                <th>
                                                    `+val.UoM+`
                                                </th>
                                                <td  class='align-middle'>
                                                    <textarea class='form-control product_input-Description' rows='3'></textarea>
                                                </td>
                                                <td  class='align-middle'>
                                                    // <label class='product_label-Price'>Rp 123.123.123</label>
                                                    <input type='text' class='form-control product_input-Price'>
                                                </td>
                                                <td  class='align-middle'>
                                                    <button type='button' class='btn btn-danger product_removeitem'>
                                                        <i class='fas fa-times'></i>
                                                    </button>
                                                </td>
                                            </tr>`);
                    $(tabContent).find('tbody').append(tabContentItem)
                })

                $('#form-project-product .nav-tabs').append(tab)    
                $('#form-project-product .tab-content').append(tabContent)    
            }

            function createProductTab(x){
                var productName = 'Produk '+(parseInt(x)+1)

                var tab = $(`<li class='nav-item'>
                                <a class='nav-link `+(x == 0? 'active' : '')+`' data-toggle='tab' href='#product_`+x+`'>`+productName+`</a>
                            </li>`)

                $('#form-project-product .nav-tabs').append(tab)
            }
        // ===================== END SELECT 2 PRODUCT =====================

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
                $(this).parents(`tr[id^='item_row-']`).find('.item_input-Qty').attr('value', 1)
                $(this).parents(`tr[id^='item_row-']`).find('.item_Price-label').html(numberFormat('', suggestion.Price))
                $(this).parents(`tr[id^='item_row-']`).find('.item_input-Price').attr('value', suggestion.Price)
                $(this).parents(`tr[id^='item_row-']`).find('.item_input-Price').attr('data-price', suggestion.Price)

                $('.calc').trigger('keyup')

                if(suggestion.StatusPrice == 0){
                    $(this).parents('tr').attr('style','background-color:#fdd8d8')
                    $(this).parents('tr').find('.price-exp').html(suggestion.LastUpdated)
                }else{
                    $(this).parents('tr').removeAttr('style')
                    $(this).parents('tr').find('.price-exp').html('')
                }
            }else{
                alert('item sudah dipilih sebelumnya')
                // $(this).parents(`tr[id^='item_row-']`).find('.item_input-ItemName').typeahead('val', '')
                // $(this).parents(`tr[id^='item_row-']`).find('.item_input-IdItem').val('')
                // $(this).parents(`tr[id^='item_row-']`).find('.item_input-IdItem').attr('data-text', '')
                // $(this).parents(`tr[id^='item_row-']`).find('.item_input-ItemUoM').text('-')
            }
        })

		// ================== FUNCTION ==================
            $('body').on('keypress', '.isNumber', function (evt){
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;

                if (charCode != 46 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
                return true;
            })

            $('body').on('keyup', '.calc', function(){
                var qty = $(this).parents('tr').find('.item_input-Qty').val()
                var price = $(this).parents('tr').find('.item_input-Price').attr('data-price')

                qty = (qty ? parseFloat(qty):0);
                price = (price ? parseInt(price):0)

                var totalPrice = qty * price
                var totalCost = 0
                var grandTotal = 0
                var margin = ($('.item_input-MarginNominal').val()? $('.item_input-MarginNominal').val() : 0)

                $(this).parents('tr').find('.item_input-Price').val(totalPrice)
                $(this).parents('tr').find('.item_Price-label').html(numberFormat('',totalPrice))

                $('.item_input-Price').each(function(){
                    totalCost += parseInt($(this).val())
                })

                grandTotal += parseInt(margin) + parseInt(totalCost)

                $('.item_input-TotalCost').val(totalCost)
                $('.item_label-TotalCost').html(numberFormat('', totalCost))

                $('.item_input-GrandTotal').val(grandTotal)
                $('.item_GrandTotal-label').html(numberFormat('', grandTotal))
            })

            $('body').on('click', '.item_remove', function(){
                if($(`tr[id^='item_row-']`).length > 1){
                    $(this).parents('tr').remove()

                    $(`tr[id^='item_row-']`).each(function(x){
                        $(this).find('td:nth-child(1)').html(parseInt(x)+1)

                        $(this).find(`:input[name^='ProjectItem']`).each(function(){
                            var name = $(this).attr('name').split(/[[\]]{1,2}/)
                            
                            $(this).attr('name', 'ProjectItem['+x+']['+name[2]+']')
                        })
                    })
                }else{
                    $(this).parents(`tr`).find(':input').val('')
                    $(this).parents(`tr`).removeAttr('style')
                    $(this).parents(`tr`).find('.item_input-IdItem').attr('value', '')
                    $(this).parents(`tr`).find('.item_input-IdItem').attr('data-text', '')
                }

                $('.calc').trigger('keyup')
            })

			function createItemRow(lastNumber, itemName = '', idItem = '', qty = '', price = ''){
                var itemContent = $(`<tr id='item_row-`+lastNumber+`'>
					    				<td>`+parseInt(lastNumber+1)+`</td>
					    				<td>
					    					<input class='form-control item_input-ItemName' name='ProjectItem[`+lastNumber+`][ItemName]' placeholder='Item. . .' value='`+itemName+`' data-text='`+itemName+`'>
					    					<input type='hidden' class='form-control item_input-IdItem' placeholder='this supposed to be hidden' name='ProjectItem[`+lastNumber+`][IdItem]' value='`+idItem+`'>
					    				</td>
					    				<td>
					    					<div class='input-group mb-3'>
												<input class='form-control item_input-Qty isNumber calc' name='ProjectItem[`+lastNumber+`][Qty]' placeholder='Qty. . .' value='`+qty+`'>
												<div class='input-group-append'>
													<span class='input-group-text item_input-ItemUoM'>-</span>
												</div>
											</div>
					    				</td>
					    				<td class='text-right'>
                                            <label class='item_Price-label'></label>
                                            <br>
                                            <small class='price-exp'></small>
					    					<input type='hidden' class='form-control item_input-Price isNumber calc' name='ProjectItem[`+lastNumber+`][Price]' placeholder='Price. . .' value='`+price+`' data-price='`+price+`'>
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