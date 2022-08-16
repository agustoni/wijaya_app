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
	    	url: _url+'backend/product/get-all-item',
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
                    url: _url+'backend/product/save-product',
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
		$.ajax({
            type: 'POST',
            url: _url+'backend/product/delete-product-item',
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