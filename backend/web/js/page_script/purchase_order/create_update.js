$(document).ready(function(){
	if(arrPoItem){
        $.each(arrPoItem, function(idx, val){
            createPOItem(idx, '', val.idSupplierItem, val.uom, val.itemName, val.idSupplier, val.supplierName, val.qty, val.price, val.total, val.idPoItem, statusUpdate)
        })

        changePoTotal(_poTotal)
	}else{
		createPOItem(0)
	}

	$('#add-project-item').click(function(){
		var lastNumber = (typeof $('#project-item-list').find('tbody tr td:nth-child(1)').last().html() !== 'undefined'? 
                                parseInt($('#project-item-list').find('tbody tr td:nth-child(1)').last().html()) : 
                                0)
        $('#project-item-list').find('table tbody').append(createPOItem(lastNumber))
	})

	$('body').on('typeahead:select', '.poitem_input-ItemName', function(ev, suggestion) {
        if($('.poitem_input-IdSupplierItem[value='+suggestion.IdSupplierItem+']').length > 0){
        	var itemName = $(this).parents('tr').find('.poitem_input-IdSupplierItem').attr('data-text')

        	$(this).parents('tr').find('.poitem_input-ItemName').typeahead('val', itemName)
        	alert('item sudah dimasukan sebelumnya')
        }else{
        	$(this).parents('tr').find('.poitem_input-IdSupplierItem').val(suggestion.IdSupplierItem)
            $(this).parents('tr').find('.poitem_input-IdSupplierItem').attr('value', suggestion.IdSupplierItem)
            $(this).parents('tr').find('.poitem_input-IdSupplierItem').attr('data-text', suggestion.ItemName)

            getSupplierItem($(this).parents('tr'), suggestion.IdItem, suggestion.UoM, suggestion.ItemName)
        }  
    })

    $('body').on('typeahead:change', '.poitem_input-ItemName', function(ev, suggestion) {
    	var itemName = $(this).parents('tr').find('.poitem_input-IdSupplierItem').attr('data-text')
    	$(this).parents('tr').find('.poitem_input-ItemName').typeahead('val', itemName)
    })

    $("body").on("keypress change", ".isNumber", function (evt){
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;

        if (charCode == 46 || (charCode < 48 || charCode > 57)) {
            return false;
        }

        value = $(this).val().replace(/^(0*)/,"");
        $(this).val(value);

        return true;
    })

    $("body").on("keyup", ".calc", function(){
    	var el = $(this).parents("tr")
    	var price = $(el).find(".poitem_input-Price").val()? $(el).find(".poitem_input-Price").val() : 0
    	var qty = $(el).find(".poitem_input-Qty").val()? $(el).find(".poitem_input-Qty").val() : 0
    	
    	if($(this).hasClass('poitem_input-Price')){
    		price = $(this).val()
    	}

    	var total = parseInt(price) * parseInt(qty)
    	$(el).find(".poitem_input-Total").val(total)

    	changePoTotal()
    })

    $("body").on("click", ".poitem_remove", function(){
    	if(confirm("Hapus item?")){
    		var tr = $(this).parents("tr")
	    	var tbody = $(this).parents("tbody")
            var idPoItem = $(this).data('idpoitem')

            var deleteRow = function(tr){
                if($("#project-item-list tbody tr").length > 1){
                    tr.remove()
                    $(tbody).find('tr').each(function(x){
                        $(this).find('td:nth-child(1)').html(parseInt(x)+1)
                        $(this).attr("id", "poitem-row_"+x)
                    })
                }else{
                    $("#project-item-list tbody tr").find(":input").val("")
                }

                changePoTotal()
            }
            
            if(idPoItem){
                $.when(ajaxDeletePoItem(idPoItem)).done(function(e) {
                    if(e.success){
                        deleteRow(tr)
                    }else{
                        alert(e.message)
                    }
                })
            }else{
                deleteRow(tr)
            }
    	}
    })

    function ajaxDeletePoItem(idPoItem){
        return $.ajax({
            type: 'POST',
            url: _url+'backend/purchase-order/delete-po-item',
            data: {idPoItem},
            dataType:'json',
            async: true,
            beforeSend: function() {
                $('#po-form-container').busyLoad('show', {spinner: 'cube',text: 'loading'})
            },
            success: function(d){
                
            },
        }).complete(function(d){
            $('#po-form-container').busyLoad('hide')
        })
    }

    $("body").on("change", ".poitem_input-IdSupplier", function(){
    	var price = $(this).parents('tr').find('.poitem_input-IdSupplier :selected').attr('data-price')
    	$(this).parents('tr').find('.poitem_input-Price').val(price)

    	$(".calc").keyup()
    	changePoTotal()
    })

    $("#submit-po").click(function(){
    	var validate = true
    	var dataPoItem = {}
    	$("tr[id^='poitem-row_']").each(function(idx){
    		var idProjectItem = $(this).find('.poitem_input-IdProjectItem').val()
    		var idPoItem = $(this).find('.poitem_input-IdPoItem').val()
    		var idSupplierItem = $(this).find('.poitem_input-IdSupplierItem').val()
    		var idSupplier = $(this).find('.poitem_input-IdSupplier').val()
    		var qty = $(this).find('.poitem_input-Qty').val()
    		var price = $(this).find('.poitem_input-Price').val()
    		var total = $(this).find('.poitem_input-Total').val()

    		if(!idSupplierItem || !idSupplier || !qty || !price || !total){
    			validate = false
    			$(this).find(":input").not("button").addClass("border-danger")
    		}else{
    			$(this).find(":input").not("button").removeClass("border-danger")

    			dataPoItem[idx] = {
                    idPo: idPo,
    				idProjectItem: (idProjectItem? idProjectItem : null),
    				idPoItem: (idPoItem? idPoItem : null),
    				idSupplier: (idSupplier? idSupplier : null),
    				idSupplierItem: (idSupplierItem? idSupplierItem : 0),
    				qty: (qty? qty : 0),
    				price: (price? price : 0),
    				total: (total? total : 0),
    			}
    		}
    	})

    	if(!validate){
    		alert('data belum lengkap')
    		return false
    	}

    	if(confirm("Submit PO?")){
    		$.ajax({
	            type: 'POST',
	            url: _url+'backend/purchase-order/submit-po',
	            data: {dataPoItem},
	            dataType:'json',
	            async: true,
	            beforeSend: function() {
	                $('#po-form-container').busyLoad('show', {spinner: 'cube',text: 'loading'})
	            },
	            success: function(d){
	                if(d.success){
                        var poNum = d.PO.join(', ')

                        if(idPo){
                            alert('PO '+poNum+' berhasil dibuat/di-update')
                            window.location.reload()
                        }else{
                            alert('PO '+poNum+' berhasil dibuat')
                            window.location.href = _url+'backend/purchase-order/index';
                        }
	                }else{
	                	alert(d.message)
	                }
	            },
	        }).complete(function(d){
	            $('#po-form-container').busyLoad('hide')
	        })
    	}
    })

    function getSupplierItem(el, IdItem, UoM, ItemName){
    	$.ajax({
            type: 'POST',
            url: _url+'backend/purchase-order/get-supplier-item',
            data: {IdItem},
            dataType:'json',
            async: true,
            beforeSend: function() {
                $('#po-form-container').busyLoad('show', {spinner: 'cube',text: 'loading'})
            },
            success: function(d){
                if(d.length > 0){
                	$(el).find('.poitem_input-IdSupplier').empty()

                	$(d).each(function(idx, val){
                		var option = $(`<option value='`+val.IdSupplier+`' `+(idx == 0 ? 'selected' : '')+` data-price='`+val.Price+`'>`+val.SupplierName+`</option>`)
                		$(el).find('.poitem_input-IdSupplier').append(option)
                	})

                	var price = $(el).find(".poitem_input-IdSupplier :selected").attr('data-price')

                	$(el).find(".poitem_input-IdSupplierItem").attr('data-text', ItemName)
                	$(el).find(".poitem_input-UoM").html(UoM)
		        	$(el).find(".poitem_input-Qty").val(1)
		        	$(el).find(".poitem_input-Price").val(price)
		        	$(el).find(".poitem_input-Total").val(price)
                }else{
                	alert('Supplier untuk item yang dipilih tidak ditemukan')
                }
            },
        }).complete(function(d){
            $('#po-form-container').busyLoad('hide')
            changePoTotal()
        })
    }

	function createPOItem(lastNumber, idProjectItem = '', idSupplierItem = '', uom = '-', itemName = '', idSupplier = '', supplierName = '', qty = 1, price = 0, total = 0, idPoItem = '', update=true){
        var poItemContent = $(`<tr id='poitem-row_`+lastNumber+`'>
									<td class='align-middle text-center'>`+(lastNumber + 1)+`</td>
									<td class='align-middle'>
                                        `+(idSupplierItem? 
                                            '<span>'+itemName+'</span>' :
                                            '<input class="form-control poitem_input-ItemName" value="'+itemName+'">')+`
										<input class='form-control poitem_input-IdSupplierItem d-none' data-text='`+itemName+`' value='`+idSupplierItem+`'>
										<input class='poitem_input-IdProjectItem d-none' value='`+idProjectItem+`'>
										<input class='form-control poitem_input-IdPoItem d-none' value='`+idPoItem+`'>
									</td>
									<td class='align-middle'>
										<span class='poitem_input-UoM'>`+uom+`</span>
									</td>
									<td class='align-middle'>
                                        `+(idSupplier? 
                                            '<span>'+supplierName+'</span><input class="poitem_input-IdSupplier d-none" value="'+idSupplier+'">' : 
                                            '<select class="form-control poitem_input-IdSupplier"></select>')+`
									</td>
									<td class='align-middle'>
                                        `+(update? 
                                            '<input class="form-control poitem_input-Qty isNumber calc" value="'+qty+'">' : 
                                            '<span>'+numberFormat('', qty)+'</span>')+`
									</td>
									<td class='align-middle'>
                                        `+(update?
                                            '<input class="form-control poitem_input-Price calc isNumber" value="'+price+'">' :
                                            '<span class="float-left">Rp</span> <span class="float-right">'+numberFormat('', price)+'</span>')+`
									</td>
									<td class='align-middle'>
                                        `+(update?
                                            '<input class="form-control poitem_input-Total isNumber text-right" value="'+total+'" readonly>' :
                                            '<span class="float-left">Rp</span> <span class="float-right font-weight-bold">'+numberFormat('', total)+'</span>')+`
									</td>
									<td class='align-middle text-center'>
                                        `+(update?
                                            '<button type="button" class="btn btn-danger poitem_remove" data-idpoitem="'+idPoItem+'"><i class="fas fa-times"></i></button>' :
                                            '')+`
									</td>
							   </tr>`)

		$('#project-item-list tbody').append(poItemContent)
		itemTypeaheadInit($('#project-item-list tbody').find('#poitem-row_'+lastNumber+' .poitem_input-ItemName'))
	}

	function itemTypeaheadInit(inputTypeahead){
        var urlTypeahead

        if(idPo){
            urlTypeahead = _url+'backend/purchase-order/get-sales-item?q=%QUERY&idSupplier='+arrPoItem[0]['idSupplier']
        }else{
            urlTypeahead = _url+'backend/purchase-order/get-sales-item?q=%QUERY'
        }

        var src = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: urlTypeahead,
                wildcard: '%QUERY'
            }
        })

        inputTypeahead.typeahead(null, {
            name: 'name',
            display: 'ItemName',
            source: src
        })
    }

    function changePoTotal(savedPoTotal=0){
    	var poTotal = savedPoTotal? savedPoTotal : 0

        if(savedPoTotal == 0){
            $(".poitem_input-Total").each(function(){
                poTotal += $(this).val()? parseInt($(this).val()) : 0
            })
        }

		$("#po-total").html(numberFormat('', poTotal))
    }
})