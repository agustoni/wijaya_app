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
	#product-item-list td, th{vertical-align: middle}
</style>
<div class="card card-light mb-3" id="product-container">
    <div class="card-header bg-info text-white p-2">
        <h4 class="card-title m-0">Produk</h4>
    </div>
    <div class="car-body p-2">
    	<div class="row mb-2">
    		<div class="col-md-8">
    			<label class="font-weight-bold" for="product_input-Name">Nama Produk</label>
                <input type="text" class="form-control" id="item_input-ItemName" placeholder="Nama Product. . ." name="Product[Name]" value="<?= (isset($model->Name)? $model->Name : '') ?>">
    		</div>
    	</div>
    	<div class="row mb-2">
    		<div class="col-md-8">
    			<label class="font-weight-bold">Item Yang Dibutuhkan</label>
                <select class="form-control select2-itemlist-input"></select>
    		</div>
    	</div>
    	<hr>

    	<h4>List Item Produk</h4>
    	<table class="table table-striped mb-4" id="product-item-list">
    		<thead>
    			<tr>
    				<th style="width: 10%">#</th>
    				<th style="width: 33%">Item</th>
    				<th style="width: 50%">Deskirpsi</th>
    				<th style="width: 7%"></th>
    			</tr>	
    		</thead>
    		<tbody>
    			
    		</tbody>
    	</table>

    	<div class="row float-right">
    		<div class="col-md">
    			<button type="button" class="btn btn-success" id="save_Product">Save</button>
    		</div>
    	</div>
    </div>
</div>
<?php 
	$scriptFormProductMaster = "
		var idProduct = ".(isset($_GET['id'])? $_GET['id'] : 0)."
		var productItemList = ".(isset($productItemList) || !empty($productItemList) ? $productItemList : 'null')."
		var alertEmpty = $(`<tr id='alert-product-itemlist-empty' class='text-center'><td colspan='4'>Belum ada item yang dimasukan ke product ini</td></tr>`)

		$(document).ready(function(){
			if(!productItemList){
				$('#product-item-list tbody').append(alertEmpty)
			}else{
				$.each(productItemList, function(key, val) {
					createItemList(val.IdItem, val.Name, val.Description, val.IdProductItem, 1)
				});
			}

			$('.select2-itemlist-input').select2({
			 	ajax: {
			    	url: '".Yii::$app->urlManager->createUrl("product/get-all-item")."',
			    	dataType: 'json',
			    	processResults: function (data) {
				      	return {
				        	results: data
				      	}
				    }
			  	}
			})

			$('.select2-itemlist-input').on('select2:select', function (e) {
			 	var selected = e.params.data

			 	if($('.itemlist_input-IdItem').length == 0 || $('.itemlist_input-IdItem[value='+selected.id+']').length == 0){
			 		createItemList(selected.id, selected.text)
			 	}else{
			 		alert(selected.text+' sudah ada dalam list product')
			 	}

			 	$('.select2-itemlist-input').val(null).trigger('change')
			})

			$('body').on('click', '.itemlist_remove', function(){
				var dataUpdate = $(this).parents('tr').find('.itemlist_input-IdProductItem').val()
                
                if(confirm('Apakah Anda yakin?')){
	                if(dataUpdate){
	                    deleteProductItem(dataUpdate, $(this))    
	                }else{
	                	removeProductItemRow($(this))
	                }
                }
			})

			$('#save_Product').click(function(){
				var validate = true
				var data = new FormData()
				var productName = $('#item_input-ItemName').val()

				data.append('Product[IdProduct]', idProduct)

				if(!productName){
					alert('nama product belum terisi')
					return false
				}else{
					data.append('Product[Name]', productName)
				}

				$(`tr[id^='itemlist_row-']`).each(function(x){
					var idItem = $(this).find('.itemlist_input-IdItem').val()
					var description = $(this).find('.itemlist_input-Description').val()
					var idProductItem = $(this).find('.itemlist_input-IdProductItem').val()

					if(!idItem){
						alert('item list belum terisi')
						validate = false
						return false
					}else{
						data.append('Product[ItemList]['+x+'][IdItem]', idItem)
						data.append('Product[ItemList]['+x+'][Description]', description)
						data.append('Product[ItemList]['+x+'][IdProductItem]', idProductItem)
					}
				})

				if(validate){
					if(confirm('Simpan data produk?')){
                        $.ajax({
                            type: 'POST',
                            url: '".Yii::$app->urlManager->createUrl("product/save-product")."',
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
                                    alert('Data berhasil di-update/dibuat')
                                    location.reload()
                                }
                            },
                        }).complete(function(d){
                            $('#layoutSidenav_content').busyLoad('hide')
                        })
                    }
				}
			})

			function removeProductItemRow(el){
				$(el).parents('tr').remove()

            	$('#product-item-list').find(`tr[id^='itemlist_row-']`).each(function(x){
                    $(this).find('td:nth-child(1)').html(parseInt(x)+1)
                    $(this).attr('id', 'itemlist_row-'+x)

                    $(this).find(`:input[name^='ProductItem']`).each(function(){
                        var name = $(this).attr('name').split(/[[\]]{1,2}/)
                        
                        $(this).attr('name', 'ProductItem['+x+']['+name[2]+']')
                    })
                })
			}

			function deleteProductItem(id, el){
				console.log(id)
				$.ajax({
                    type: 'POST',
                    url: '".Yii::$app->urlManager->createUrl("product/delete-product-item")."',
                    data: {id},
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
                            removeProductItemRow(el)
                        }
                    },
                }).complete(function(d){
                    $('#layoutSidenav_content').busyLoad('hide')
                })
			}

			function createItemList(idItem, itemName, description='', idProductItem=''){
				if($('#alert-product-itemlist-empty').length == 1){
					$('#alert-product-itemlist-empty').remove()
				}

				var lastNumber = (typeof $('#product-item-list tbody tr td:nth-child(1)').last().html() !== 'undefined'? parseInt($('#product-item-list tbody tr td:nth-child(1)').last().html()) : 0)

				var itemListContent = $(`<tr id='itemlist_row-`+lastNumber+`'>
											<td>`+(lastNumber + 1)+`</td>
											<td>
												`+itemName+`
												<input type='hidden' class='itemlist_input-IdProductItem' value='`+idProductItem+`' name='ProductItem[`+lastNumber+`][IdProductItem]'>
												<input type='hidden' class='itemlist_input-IdItem' value='`+idItem+`' name='ProductItem[`+lastNumber+`][IdItem]'>
											</td>
											<td>
												<textarea class='form-control itemlist_input-Description' name='ProductItem[`+lastNumber+`][Description]' placeholder='Deskripsi. . .'>`+description+`</textarea>
											</td>
											<td>
												<button type='button' class='btn btn-danger itemlist_remove'>
													<i class='fas fa-times'></i>
												</button>
											</td>
										 </tr>
										`)

				$('#product-item-list tbody').append(itemListContent)
			}
		})
	";

    $this->registerJs($scriptFormProductMaster, \yii\web\View::POS_END);
?>