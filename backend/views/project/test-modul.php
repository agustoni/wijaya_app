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

    .table-product-item tfoot{border-top: 2px solid #eee;background-color: #eee;}

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

        <div id="form-project-product">
            <ul class="nav nav-tabs" role="tablist">
                <li class='nav-item' id="nav-tab-summary">
                    <a class='nav-link active' data-toggle='tab' href='#tab-content-summary'>
                        Rangkuman
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="tab-content-summary" class='tab-pane active'>
                    <!-- <h3 class='product_label-ProductName'>asdasd</h3>
                    <hr> -->
                    
                    <table class="table table-striped table-summary table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Modal</th>
                                <th>Harga</th>
                                <th>Margin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Lift 1</td>
                                <td>Rp 3.000.000</td>
                                <td>Rp 5.000.000</td>
                                <td>Rp 2.000.000</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Lift 2</td>
                                <td>Rp 3.000.000</td>
                                <td>Rp 5.000.000</td>
                                <td>Rp 2.000.000</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Lift 3</td>
                                <td>Rp 3.000.000</td>
                                <td>Rp 5.000.000</td>
                                <td>Rp 2.000.000</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Lift 4</td>
                                <td>Rp 3.000.000</td>
                                <td>Rp 5.000.000</td>
                                <td>Rp 2.000.000</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Lift 5</td>
                                <td>Rp 3.000.000</td>
                                <td>Rp 5.000.000</td>
                                <td>Rp 2.000.000</td>
                            </tr>
                        </tbody>
                        <tfoot class='bg-success text-white'>
                            <tr>
                                <th colspan=2 class="text-center">Total</th>
                                <th>Rp 15.000.000</th>
                                <th>Rp 25.000.000</th>
                                 <th>Rp 10.000.000</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
	$scriptDetailItem = "
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

                $('.select2-product-input').val(null).trigger('change')

                createProduct(selected)
            })

            function createProduct(data){
                $('.nav-link').removeClass('active')
                $('.tab-pane').removeClass('active')

                var x = $('#form-project-product .nav-tabs .list-tab-product').length
                var productName = 'Produk '+(parseInt(x)+1)
                var tab = $(`<li class='nav-item'>
                                <a class='nav-link active list-tab-product' data-toggle='tab' href='#product_`+x+`'>`+productName+`</a>
                            </li>`)

                var tabContent = $(`<div id='product_`+x+`' class='tab-pane active'>
                                        <h3 class='product_label-ProductName'>`+data.text+`</h3>
                                        <hr>
                                        <table class='table table-borderless table-sm table-product-item'>
                                            <thead>
                                                <th class='text-center'>#</th>
                                                <th>Item</th>
                                                <th>Qty</th>
                                                <th>UoM</th>
                                                <th>Deskripsi</th>
                                                <th>Total</th>
                                                <th></th>
                                            </thead>
                                            <tbody>
                                                
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan=5 class='align-middle text-right'>Modal</th>
                                                    <th colspan=2 class='align-middle text-right'>
                                                        <label class='product_label-TotalCost '></label>
                                                        <!-- <input class='form-control product_input-TotalCost text-right'> -->
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan=5 class='align-middle text-right'>Margin</th>
                                                    <th colspan=2 class='align-middle text-right'>
                                                        <div class='input-group'>
                                                            <div class='input-group-prepend w-25'>
                                                                <input class='form-control product_input-TotaPercent text-right isNumber' placeholder='Persen. . .'>
                                                            </div>
                                                            
                                                            <input class='form-control product_input-TotalMargin text-right isNumber'>
                                                        </div>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan=5 class='align-middle text-right'>Harga Jual</th>
                                                    <th colspan=2 class='align-middle text-right'>
                                                        <label class='product_label-TotalPrice '></label>
                                                        <input type='hidden' class='form-control product_input-TotalPrice text-right' readonly>
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <div class='col-md-12'>
                                            <button class='btn btn-warning btn-sm add-product-item'>
                                                <i class='fas fa-plus text-white'></i>
                                            </button>
                                        </div>
                                    </div>`)

                $(data.listitem).each(function(i, val){
                    $(tabContent).find('tbody').append(createProductItem(i, false, val.IdItem, val.ItemName, val.Qty, val.UoM, val.Cost, val.StatusExp, val.LastUpdated))
                })

                $(tab).insertBefore('#nav-tab-summary')
                $(tabContent).insertBefore('#tab-content-summary')

                calcTotal()
            }

            function createProductItem(i, inputSelect, IdItem='', ItemName='', Qty='', UoM='-', Cost='0', StatusExp='', LastUpdated=''){
                var statusAlert = ''
                var lastUpdate = ''

                if(!inputSelect){
                    var inputItem = $(`<label class='product_label-Item'>`+ItemName+`</label>
                                    <input type='hidden' class='form-control product_input-IdItem' value='`+IdItem+`' placeholder='supposed to be hidden'>`)
                }else{
                    var inputItem = $(`<input class='form-control product_input-Item' placeholder='Item. . .'>
                                        <input type='hidden' class='form-control product_input-IdItem' value='' placeholder='supposed to be hidden'>`)
                }

                if(StatusExp == 0){
                    statusAlert = 'style=background-color:#fdd8d8'
                    lastUpdate = LastUpdated
                }

                var totalCost = parseInt(Qty? Qty : 0) * parseInt(Cost? Cost : 0)

                var tabContentItem = $(`<tr id='item_row-`+i+`' `+statusAlert+`>
                                            <td class='align-middle text-center'>`+(parseInt(i)+1)+`</td>
                                            <td class='align-middle product-item'></td>
                                            <td  class='align-middle'>
                                                <input type='number' class='form-control product_input-Qty calc isNumber' value='`+Qty+`'>
                                            </td>
                                            <td class='align-middle product_label-UoM'>
                                                `+UoM+`
                                            </t>
                                            <td  class='align-middle'>
                                                <textarea class='form-control product_input-Description' rows='3'></textarea>
                                            </td>
                                            <td  class='align-middle'>
                                                <!-- <label class='product_label-TotalPrice'>Rp 123.123.123</label> -->
                                                <small class='product_label-Cost'>`+numberFormat('Rp', Cost)+`</small>
                                                <input type='text' class='form-control product_input-Cost calc text-right isNumber' value='`+totalCost+`' data-Cost='`+Cost+`'>
                                                <small class='cost-exp'>`+lastUpdate+`</small>
                                            </td>
                                            <td  class='align-middle text-right'>
                                                <button type='button' class='btn btn-danger product_removeitem'>
                                                    <i class='fas fa-times'></i>
                                                </button>
                                            </td>
                                        </tr>`)
                tabContentItem.find('.product-item').append(inputItem)

                return tabContentItem
            }

            $('body').on('click', '.add-product-item', function(){
                var parentTabProduct = $(this).parents('.tab-pane')
                var lastNumber = (typeof $(parentTabProduct).find('.table-product-item tbody tr td:nth-child(1)').last().html() !== 'undefined'? 
                                            parseInt($(parentTabProduct).find('.table-product-item tbody tr td:nth-child(1)').last().html()) 
                                            : 0)

                $(parentTabProduct).find('table tbody').append(createProductItem(lastNumber, 1))
                itemTypeaheadInit($(parentTabProduct).find('#item_row-'+lastNumber+' .product_input-Item'))
            })

            $('body').on('keyup', '.product_input-Item', function(e){
                if(e.keyCode == 46 || e.keyCode == 8) {
                    $(this).parents(`tr[id^='item_row-']`).find('.product_input-Item').typeahead('val', '')
                    $(this).parents(`tr[id^='item_row-']`).find('.product_input-IdItem').val('')
                    $(this).parents(`tr[id^='item_row-']`).find('.product_label-UoM').text('-')
                }
            })

            $('body').on('typeahead:change', '.product_input-Item', function(ev, suggestion) {
                $(this).parents(`tr[id^='item_row-']`).find('.product_input-Item').typeahead(
                    'val', 
                    $(this).parents(`tr[id^='item_row-']`).find('.item_input-IdItem').attr('data-text')
                )
            })

            $('body').on('typeahead:select', '.product_input-Item', function(ev, suggestion) {
                if($('.product_input-IdItem[value='+suggestion.IdItem+']').length == 0){
                    $(this).parents(`tr[id^='item_row-']`).find('.product_input-IdItem').val(suggestion.IdItem)
                    $(this).parents(`tr[id^='item_row-']`).find('.product_input-IdItem').attr('value', suggestion.IdItem)
                    $(this).parents(`tr[id^='item_row-']`).find('.product_label-UoM').text(suggestion.UoM)
                    $(this).parents(`tr[id^='item_row-']`).find('.product_input-Qty').attr('value', 1)
                    $(this).parents(`tr[id^='item_row-']`).find('.product_label-Cost').html(numberFormat('Rp', suggestion.Cost))
                    $(this).parents(`tr[id^='item_row-']`).find('.product_input-Cost').val(suggestion.Cost)
                    $(this).parents(`tr[id^='item_row-']`).find('.product_input-Cost').attr('value', suggestion.Cost)
                    $(this).parents(`tr[id^='item_row-']`).find('.product_input-Cost').attr('data-cost', suggestion.Cost)

                    if(suggestion.StatusExp == 0){
                        $(this).parents('tr').attr('style','background-color:#fdd8d8')
                        $(this).parents('tr').find('.cost-exp').html(suggestion.LastUpdated)
                    }else{
                        $(this).parents('tr').removeAttr('style')
                        $(this).parents('tr').find('.cost-exp').html('')
                    }
                }else{
                    alert('item sudah dipilih sebelumnya')
                }

                calcTotal()
            })

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

        // ===================== END SELECT 2 PRODUCT =====================


        // ===================== CALC PRICE =====================
            $('body').on('keyup', '.product_input-TotalMargin', function(){
                $('.product_input-TotaPercent').val('')
                calcTotal()
            })

            $('body').on('keyup', '.product_input-TotaPercent', function(){
                $('.product_input-TotalMargin').val('')
                calcTotal()
            })

            function calcTotal(){
                var marginPercent = parseInt($('.product_input-TotaPercent').val()? $('.product_input-TotaPercent').val() : 0)
                var grandTotalMargin = parseInt($('.product_input-TotalMargin').val()? parseInt($('.product_input-TotalMargin').val()) : 0)
                var grandTotalPrice = 0
                var grandTotalCost = 0

                $('.product_input-Cost').each(function(idx, val){
                    grandTotalCost += parseInt($(this).val())
                })

                if($('.product_input-TotaPercent').val()){
                    grandTotalMargin = grandTotalCost * (marginPercent/100)
                }

                grandTotalPrice = grandTotalCost + grandTotalMargin

                $('.product_input-TotalCost').val(grandTotalCost)
                $('.product_input-TotalPrice').val(grandTotalPrice)

                $('.product_label-TotalCost').html(numberFormat('', grandTotalCost))
                $('.product_label-TotalMargin').html(numberFormat('', grandTotalMargin))
                $('.product_label-TotalPrice').html(numberFormat('', grandTotalPrice))
            }

            $('body').on('keyup', '.calc', function(){
                var qty = $(this).parents('tr').find('.product_input-Qty').val()
                var cost = $(this).parents('tr').find('.product_input-Cost').attr('data-cost')

                qty = (qty ? parseFloat(qty):0);
                cost = (cost ? parseInt(cost):0)

                var totalCost = qty * cost

                $(this).parents('tr').find('.product_input-Cost').val(totalCost)

                calcTotal()
            })
        // ===================== END CALC PRICE =====================

		// ================== FUNCTION ==================
            $('body').on('keypress', '.isNumber', function (evt){
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;

                if (charCode != 46 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
                return true;
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
        // ================== END FUNCTION ==================
	";

	$this->registerJs($scriptDetailItem, \yii\web\View::POS_END);
?>