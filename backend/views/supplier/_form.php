<div class="card card-light mb-3" id="supplier-master-container">
    <div class="card-header bg-info text-white p-2">
        <h4 class="card-title m-0">Supplier Master</h4>
    </div>
    <div class="card-body p-2">
    	<!-- MASTER SUPPLIER -->
    	<div class="form-row">
            <div class="form-group col-md-5">
                <label class="font-weight-bold" for="supplier_input-Name">Nama Supplier</label>
                <input type="text" class="form-control" id="supplier_input-Name" placeholder="Nama Supplier. . ." name="Supplier[Name]" value="<?= ($model->Name? $model->Name : '') ?>">
                <!-- <input type="text" class="form-control" id="supplier_input-IdSupplier" name="Supplier[IdSupplier]" value="<?= ($model->Id? $model->Id : '') ?>"> -->
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-5">
                <label class="font-weight-bold" for="supplier_input-Address">Alamat</label>
                <textarea class="form-control" id="supplier_input-Address" rows=3 placeholder="Alamat. . ." name="Supplier[Address]"><?= ($model->Address? $model->Address : '') ?></textarea>
            </div>
            <div class="form-group col-md-5 offset-md-1">
            	<label class="font-weight-bold" for="supplier_input-Description">Keterangan</label>
                <textarea class="form-control" id="supplier_input-Description" rows=3 placeholder="Keterangan. . ." name="Supplier[Description]"><?= ($model->Description? $model->Description : '') ?></textarea>
            </div>
        </div>
        <!-- END MASTER SUPPLIER -->

        <!-- CONTACT -->
        <hr>
        <h4>Kontak</h4>
        <div class="form-row form-label">
    		<div class="col-md-1 text-center"><label class="font-weight-bold">#</label></div>
    		<div class="col-md-3"><label class="font-weight-bold">Nama</label></div>
            <div class="col-md-3"><label class="font-weight-bold">Phone</label></div>
    	</div>
    	<div id="supplier-contact-list">

        </div>
        <div class="form-row mt-4">
        	<div class="col-md-6">
        		<button class="btn btn-warning" id="btn-add-suppliercontact"><i class="fas fa-plus text-white"></i></button>
        	</div>
            <div class="col-md-6 text-right">
                <button type="button" class="btn btn-success" id="save_Supplier">Save</button>
            </div>
        </div>
    	<!-- END CONTACT -->

        <!-- <div class="form-row">
        	<div class="form-group col-md-12 text-right">
        		<button type="buttom" class="btn btn-success" id="save_Supplier">Save</button>
        	</div>
        </div> -->
    </div>
</div>
<?php
    $scriptSupplierForm="
        var actionId = '".Yii::$app->controller->action->id."'

        if(actionId == 'create'){
        	$('body').on('change', '#supplier_input-Name', function(){
	        	var supplierName = $(this).val()

	        	if(supplierName){
	        		$.ajax({
		                type: 'POST',
		                url: '".Yii::$app->urlManager->createUrl("supplier/check-supplier-name")."',
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
        	$(document).ready(function(){
        		if(typeof supplierContact !== null){
        			$(supplierContact).each(function(idx, val){
        				createSupplierContactRow(idx, val.Name, val.Phone, val.IdSupplierContact)
        			})
        		}
			})
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
	                                    $('#supplier-master-container .card-body :input').val('')
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
                    url: '".Yii::$app->urlManager->createUrl("supplier/delete-supplier-contact")."',
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
    ";

    $this->registerJs($scriptSupplierForm, \yii\web\View::POS_END);
?>