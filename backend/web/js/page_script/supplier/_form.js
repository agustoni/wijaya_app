$(document).ready(function(){
    if(actionId == 'create'){
    	$('body').on('change', '#supplier_input-Name', function(){
        	var supplierName = $(this).val()

        	if(supplierName){
        		$.ajax({
                    type: 'POST',
                    url: _url+'backend/supplier/check-supplier-name',
                    data: {supplierName},
                    dataType:'json',
                    async: true,
                    beforeSend: function() {
                        $('#layoutSidenav_content').busyLoad('show', {spinner: 'cube',text: 'loading'})
                    },
                    success: function(d){
                    	$('#supplier-contact-list').empty()

                    	if(d.length != 0){
                    		var supplierName = d.Supplier.Name 
                    		var address = (d.Supplier.Address? d.Supplier.Address : '')
                    		var description = (d.Supplier.Description? d.Supplier.Description : '')

                    		// $('#supplier_input-IdSupplier').val(supplierId)
                    		$('#supplier_input-Address').val(address)
                    		$('#supplier_input-Description').val(description)

                    		if('SupplierContact' in d){
                    			$(d.SupplierContact).each(function(idx, val){
                    				createSupplierContactRow(idx, val.Name, val.Phone, val.IdSupplierContact)
                    			})
                    		}
                    	}else{
                    		$('#supplier_input-Address').val('')
                    		$('#supplier_input-Description').val('')
                    	}
                    },
                }).complete(function(d){
                    $('#layoutSidenav_content').busyLoad('hide')
                })
        	}
        })
    }else{
		if(typeof supplierContact !== null){
			$(supplierContact).each(function(idx, val){
				createSupplierContactRow(idx, val.Name, val.Phone, val.IdSupplierContact)
			})
		}
    }

    // ================== SAVE VALIDATION ==================
    	$('body').on('click', '#save_Supplier', function(){
    		// var supplierId = $('#supplier_input-IdSupplier').val()
    		var supplierName = $('#supplier_input-Name').val()
    		var address = $('#supplier_input-Address').val()
    		var description = $('#supplier_input-Description').val()
    		var validate = true

    		var data = new FormData()

    		if(!supplierName){
    			validate = false
    			var errorLabel = $(`<small class='text-danger error-label'>
                                        Nama supplier belum diisi
                                    </small>`)
                $('#supplier_input-Name').after(errorLabel)
    		}else{
    			$('#supplier_input-Name').parents('div').find('.error-label').remove()

    			// data.append('Supplier[IdSupplier]', supplierId)
    			data.append('Supplier[Name]', supplierName)
    			data.append('Supplier[Address]', address)
    			data.append('Supplier[Description]', description)
    		}

    		$('div[id^=suppliercontact_row-]').each(function(x){
    		    var name = $(this).find('.suppliercontact_input-Name').val()
    		    var phone = $(this).find('.suppliercontact_input-Phone').val()
    		    var idSupplierContact = $(this).find('.suppliercontact_input-IdSupplierContact').val()

    		    if(name || phone){
    		        if(!name || !phone){
    		            validate = false
    		            return false
    		        }else if(name && phone){
    			    	data.append('SupplierContact['+x+'][Name]', name)
        				data.append('SupplierContact['+x+'][Phone]', phone)
        				data.append('SupplierContact['+x+'][IdSupplierContact]', idSupplierContact)
    			    }
    		    }
    		})

            var urlSaveSupplier = _url+'backend/supplier/save-supplier'

            if(idSupplier){
                urlSaveSupplier = _url+'backend/supplier/save-supplier?id='+idSupplier
            }

    		if(validate){
    			if(confirm('Save data supplier?')){
                    $.ajax({
                        type: 'POST',
                        url: urlSaveSupplier,
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
                                if(actionId == 'view'){
                                	alert('data berhasil diperbaharui')
                                    location.reload()
                                }else if(actionId == 'create'){
                                	alert('data berhasil dimasukan')
                                    $('#form-supplier .card-body :input').val('')
                                }
                            }
                        },
                    }).complete(function(d){
                        $('#layoutSidenav_content').busyLoad('hide')
                    })
    			}
    		}else{
                alert('data yang dimasukan tidak lengkap')                 
            }
    	})
    // ================== END SAVE VALIDATION ==================

    // ================== FUNCTION ==================
    	$('#btn-add-suppliercontact').click(function(){
            var lastNumber = (typeof $('#supplier-contact-list div:nth-child(1) label').last().html() !== 'undefined'? parseInt($('#supplier-contact-list div:nth-child(1) label').last().html()) : 0)

            createSupplierContactRow(lastNumber)
        })

    	function createSupplierContactRow(lastNumber, name = '', phone = '', idSupplierContact = ''){
            var supplierContactContent = $(`<div class='form-row mb-2' id='suppliercontact_row-`+lastNumber+`'>
                                        <div class='col-md-1 my-auto text-center'>
                                            <label class='font-weight-bold'>`+(lastNumber + 1)+`</label>
                                        </div>
                                        <div class='col-md-3 my-auto'>
                                            <input class='form-control suppliercontact_input-Name' name='SupplierContact[`+lastNumber+`][Name]' placeholder='Nama. . .' value='`+name+`'>
                                            <input type='hidden' class='form-control suppliercontact_input-IdSupplierContact' name='SupplierContact[`+lastNumber+`][IdSupplierContact]' value='`+idSupplierContact+`'>
                                        </div>
                                        <div class='col-md-3 my-auto'>
                                            <input class='form-control suppliercontact_input-Phone' name='SupplierContact[`+lastNumber+`][Phone]' placeholder='Phone. . .' value='`+phone+`'>
                                        </div>
                                        <div class='col-md-1 my-auto text-center'>
                                            <button type='button' class='btn btn-danger suppliercontact-remove'>
                                                <i class='fas fa-times'></i>
                                            </button>
                                        </div>
                                    </div>`)

            $('#supplier-contact-list').append(supplierContactContent)
        }

        $('body').on('click', '.suppliercontact-remove', function(){
            var IdSupplierContact = $(this).parents('div[id^=suppliercontact_row-]').find('.suppliercontact_input-IdSupplierContact').val()
            
            if(!IdSupplierContact){
                removeSupplierContactRow($(this))    
            }else{
                // delete data if exist
                if(confirm('Apakah Anda yakin?')){
                    deleteSupplierContact(IdSupplierContact, $(this))
                }
            }
        })

        function deleteSupplierContact(IdSupplierContact, el){
            $.ajax({
                type: 'POST',
                url: _url+'backend/supplier/delete-supplier-contact',
                data: {IdSupplierContact},
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
                removeSupplierContactRow(el)
                $('#layoutSidenav_content').busyLoad('hide')
            })
        }

        function removeSupplierContactRow(el){
            if($(el).parents('#supplier-contact-list').find(`div[id^='suppliercontact_row-']`).length > 1){
                $(el).parents(`div[id^='suppliercontact_row-']`).remove()
            }else{
                $(el).parents(`div[id^='suppliercontact_row-']`).find(':input').val('')
            }

            $('#supplier-contact-list').find(`div[id^='suppliercontact_row-']`).each(function(x){
                $(this).find('div:nth-child(1) label').html(parseInt(x)+1)
                $(this).attr('id', 'suppliercontact_row-'+x)

                $(this).find(`:input[name^='SupplierContact']`).each(function(){
                    var name = $(this).attr('name').split(/[[\]]{1,2}/)
                    console.log(name)
                    
                    $(this).attr('name', 'SupplierContact['+x+']['+name[2]+']')
                })
            })
        }
    // ================== END FUNCTION ==================
})