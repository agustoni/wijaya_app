<div class="card card-light mb-3" id="project-client-container">
    <div class="card-header bg-info text-white p-2">
        <h4 class="card-title m-0">Data Perusahaan/Client</h4>
    </div>
	<div class="card-body p-2">
		<div class="form-row">
			<div class="form-group col-md-6">
	            <label class="font-weight-bold" for="item_input-ItemName">Perusahaan/Nama Client</label>
	            <input type="text" class="form-control" id="projectclient_input-Company" placeholder="Perusahaan/Nama Client. . ." name="Project[Client][Company]">
	        </div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-12">
				<label class="font-weight-bold" for="item_input-ItemName">Alamat</label>
	            <textarea type="text" class="form-control" id="projectclient_input-Address" placeholder="Alamat. . ." name="Project[Client][Address]" rows=5></textarea>
			</div>
		</div>
	</div>
</div>

<div class="card card-light mb-3" id="project-contact-container">
    <div class="card-header bg-info text-white p-2">
        <h4 class="card-title m-0">Kontak</h4>
    </div>
    <div class="card-body p-2">
    	<div class="form-row form-label">
    		<div class="col-md-1 text-center"><label class="font-weight-bold">#</label></div>
    		<div class="col-md-2"><label class="font-weight-bold">Nama</label></div>
            <div class="col-md-2"><label class="font-weight-bold">Jabatan</label></div>
    		<div class="col-md-2"><label class="font-weight-bold">Role</label></div>
    		<div class="col-md-2"><label class="font-weight-bold">Phone</label></div>
    		<div class="col-md-2"><label class="font-weight-bold">Email</label></div>
    	</div>
    	<div id="project-contact-list">

        </div>
        <div class="form-row mt-4">
        	<div class="col-md-6">
        		<button class="btn btn-warning" id="btn-add-contact"><i class="fas fa-plus text-white"></i></button>
        	</div>
            <!-- <div class="col-md-6 text-right">
                <button type="button" class="btn btn-success" id="save_ItemCombined">Save</button>
            </div> -->
        </div>
    </div>
</div>
<?php
    $scriptProjectFormClient = "
    	$(document).ready(function(){
	    	if(actionId == 'create'){
	    		createContactRow(0)
	    	}

	    	$('#btn-add-contact').click(function(){
	            var lastNumber = (typeof $('#project-contact-list div:nth-child(1) label').last().html() !== 'undefined'? parseInt($('#project-contact-list div:nth-child(1) label').last().html()) : 0)

	            createContactRow(lastNumber)
	        })

	        $('body').on('click', '.projectcontact_remove-contact', function(){
	            var idProjectContact = $(this).parents('div[id^=contact_row-]').find('.projectcontact_input-IdProjectContact').val()
	            
	            if(!idProjectContact){
	                removeContactRow($(this))    
	            }else{
	                // delete data if exist
	                if(confirm('Hapus Contact?')){
	                    deleteProjectContact(idProjectContact, $(this))
	                }
	            }
	        })

	        function removeContactRow(el){
	            if($(el).parents('#project-contact-list').find(`div[id^='contact_row-']`).length > 1){
	                $(el).parents(`div[id^='contact_row-']`).remove()
	            }else{
	                $(el).parents(`div[id^='contact_row-']`).find(':input').val('')
	            }

	            $('#project-contact-list').find(`div[id^='contact_row-']`).each(function(x){
	                $(this).find('div:nth-child(1) label').html(parseInt(x)+1)
	                $(this).attr('id', 'contact_row-'+x)

	                $(this).find(`:input[name^='Project[Contact]']`).each(function(){
	                    var name = $(this).attr('name').split(/[[\]]{1,2}/)
	                    
	                    $(this).attr('name', 'Project[Contact]['+x+']['+name[3]+']')
	                })
	            })
	        }

	        function deleteProjectContact(idProjectContact, el){
	            $.ajax({
	                type: 'POST',
	                url: '".Yii::$app->urlManager->createUrl("project/delete-project-contact")."',
	                data: {idProjectContact},
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
	                removeContactRow(el)
	                $('#layoutSidenav_content').busyLoad('hide')
	            })
	        }

	    	function createContactRow(lastNumber, IdProjectContact = '', Name = '', Title = '', Role = '', Phone = '', Email = ''){
	    		var contactRowContent = $(`<div class='form-row mb-2' id='contact_row-`+lastNumber+`'>
	    										<div class='col-md-1 my-auto text-center'>
	    											<label class='font-weight-bold'>`+(lastNumber + 1)+`</label>
	    										</div>
	    										<div class='col-md-2 my-auto text-center'>
	    											<input type='text' class='form-control projectcontact_input-Name' name='Project[Contact][`+lastNumber+`][Name]' placeholder='Nama. . .' autocomplete='off' value='`+Name+`'>
	    											<input type='text' class='form-control projectcontact_input-IdProjectContact' name='Project[Contact][`+lastNumber+`][IdProjectContact]' value='`+IdProjectContact+`' placeholder='supposed to be hidden'>
	    										</div>
	    										<div class='col-md-2 my-auto text-center'>
	    											<input type='text' class='form-control projectcontact_input-Title' name='Project[Contact][`+lastNumber+`][Title]' placeholder='Jabatan. . .' autocomplete='off' value='`+Title+`'>
	    										</div>
	    										<div class='col-md-2 my-auto text-center'>
	    											<input type='text' class='form-control projectcontact_input-Role' name='Project[Contact][`+lastNumber+`][Role]' placeholder='Role. . .' autocomplete='off' value='`+Role+`'>
	    										</div>
	    										<div class='col-md-2 my-auto text-center'>
	    											<input type='text' class='form-control projectcontact_input-Phone' name='Project[Contact][`+lastNumber+`][Phone]' placeholder='Phone. . .' autocomplete='off' value='`+Phone+`'>
	    										</div>
	    										<div class='col-md-2 my-auto text-center'>
	    											<input type='text' class='form-control projectcontact_input-Email' name='Project[Contact][`+lastNumber+`][Email]' placeholder='Email. . .' autocomplete='off' value='`+Email+`'>
	    										</div>
	    										<div class='col-md-1 my-auto text-center'>
	                                                <button type='button' class='btn btn-danger projectcontact_remove-contact'>
	                                                    <i class='fas fa-times'></i>
	                                                </button>
	                                            </div>
	    								   </div>
	    		`)

	    		$('#project-contact-list').append(contactRowContent)
	    	}
	    })
    ";

    $this->registerJs($scriptProjectFormClient, \yii\web\View::POS_END);
?>