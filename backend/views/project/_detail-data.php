<?php 
    use yii\helpers\Html;

    $this->registerJsFile("https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js",[
        'depends' => [
            \yii\web\JqueryAsset::className()
        ],
        'position' => \yii\web\View::POS_END
    ]);
?>
<style>
	#upload-file-container{border-width: 2px !important;min-height: 250px;background: #d0f8ff;}
	.focus#upload-file-container{color: #495057;background-color: #bfd7de;border-color: #80bdff;outline: 0;box-shadow: 0 0 0.1rem 0.2rem rgb(0 123 255 / 25%);transition-duration:0.2s;}
	span.div-placeholder{font-size: 35px;font-weight: 600;}

	#upload-file-container .file-name{height: 50px;overflow-y: auto;}
	.remove-file{cursor: pointer;border: 1px solid;border-radius: 15px;padding: 3px 5px;top: 0;right: 0;background: #ff3434;}
	i.remove-file:hover{background: #e68989;transition: 0.2s;}
</style>
<!-- <img src="<?php //yii::getAlias('@web') ?>/web/images/icons/icon-word.png"> -->

<div class="card card-light mb-3" id="project-info-container">
    <div class="card-header bg-info text-white p-2">
        <h4 class="card-title m-0">Detail Project dan Data Lainnya</h4>
    </div>
    <div class="card-body p-2">
    	<div class="form-row my-2">
			<div class="col-md-6">
				<label class="font-weight-bold">Tipe Project</label>
				<select class="form-control" name="Project[Detail]['IdProjectType']">
					<option value="">- Tipe Project -</option>
					<?php foreach($projectType as $pt): ?>
						<option value="<?= $pt->Id ?>"><?= $pt->Type ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>

		<div class="form-row my-2">
			<div class="col-md-12">
				<div class="border border-info p-3" style="border-width: 2px !important;height: 250px;">
					<i>JSON DATA INPUT UNTUK MASING-MASING DATA YANG HARUS DIISI BERDASARKAN TIPE PROJECT</i>
				</div>
			</div>
		</div>

    	<div class="form-row my-2">
			<div class="col-md-12">
				<label class="font-weight-bold">Detail</label>
				<textarea class="form-control" name="Project[Detail]" rows="5"></textarea>
			</div>
		</div>

		<div class="form-row my-2">
			<label class="font-weight-bold">Upload File</label>
			<div class="col-md-12">
				<div class="row mx-auto border border-info p-3 d-flex" id="upload-file-container">
					<span class="div-placeholder row justify-content-center align-self-center font-italic text-secondary w-100">
						Upload atau Paste di sini
					</span>
				</div>
				<button type="button" class="btn btn-sm btn-warning position-relative text-white">
	            Upload File
	                <input type="file" id="btn-uplodad-file" name="" multiple="true" style="position: absolute;top: 0;right: 0;margin: 0;opacity: 0;-ms-filter: 'alpha(opacity=0)';font-size: 200px;direction: ltr;cursor: pointer;width: 100px;height: 30px;">
	            </button>
			</div>
		</div>
    </div>
</div>

<?php
    $scriptDetailData = "
    $(document).ready(function(){
    	if(actionId == 'create'){
    		
    	}
    	// FOCUS EFFECT
	    	$('body').click(function(e) {
				if (e.target.id == 'upload-file-container' || $(e.target).parents('#upload-file-container').length) {
					$('#upload-file-container').addClass('focus')
				} else {
					$('#upload-file-container').removeClass('focus')
				}
			})
		// FOCUS EFFECT

		// ================== UPLOAD FILE ==================
			$('#btn-uplodad-file').change(function(e){
	            readPastedFile(e.target.files)
	        })

	        $('#btn-uplodad-file').click(function(e){
	            $(this).val('')
	        })

	        $('#upload-file-container').bind('paste', function(e){
	            if(e.originalEvent.clipboardData.files[0] !== undefined){
	                readPastedFile(e.originalEvent.clipboardData.files)
	            }
	            
	            $('#upload-file-container').val('')
	            return false
	        })

	        function readPastedFile(fileList){
	        	var arrDoc = []
	        	var arrImage = []
	        	var validate = true

	        	$(fileList).each(function(idx, file){
		        	var unknownExt = 0

		        	// GET DOCUMENT
			        	if (validDocTypes.includes(file.type)) {
			        		arrDoc.push(file)
			        		arrProjectFiles['Doc'].push(file)
		                }else{
			        		unknownExt++
		                }
	                // END GET DOCUMENT

		            // GET IMAGE
		                if (validImageTypes.includes(file.type)) {
		                	arrImage.push(file)
		                	arrProjectFiles['Img'].push(file)
		                }else{
			        		unknownExt++
		                }
	                // END GET IMAGE

	                if(unknownExt == 2){
	                	validate = false
	                }
                })

                if(!validate){
                	alert('system hanya menerima file dengan extension: .csv, .xls, .xlsx, pdf, .docx, doc, .txt, .png, .jpg/.jpeg')
                }

                var totalFile = parseInt(arrDoc.length) + parseInt(arrImage.length)

                // RENDER THE FILE 
            	if(totalFile > 0){
                	$('#upload-file-container').addClass('bg-white')
                	$('#upload-file-container').find('.div-placeholder').addClass('d-none')
                }else{
                	$('#upload-file-container').removeClass('bg-white')
                	$('#upload-file-container').find('.div-placeholder').removeClass('d-none')
                }

               	if(arrDoc.length > 0){
               		renderDoc(arrDoc)
               	}

               	if(arrImage.length > 0){
               		renderImage(arrImage)
               	}
	        }

	        function renderDoc(arrDoc){
	        	var container = $('#upload-file-container')
	        	var counter = parseInt(arrProjectFiles['Doc'].length) - parseInt(arrDoc.length)

	        	$(arrDoc).each(function(idx, file){
	        		var content = $(`<div class='col-md-2 py-3 position-relative'>
	        							<div class='preview-file border p-1 text-center'>
		        							<i class='fas fa-times position-absolute remove-file text-white' data-index='Doc-`+counter+`'></i>
											<img src='`+docIcon[file.type]+`' class='img-fluid' style='max-height:160px'>
											<div class='file-name'>`+file.name+`</div>
										</div>
									</div>`) 

					container.append(content)
					counter++
	        	})
	        }
		
			function renderImage(arrImage){
				var container = $('#upload-file-container')
				var counter = parseInt(arrProjectFiles['Img'].length) - parseInt(arrImage.length)

	        	$(arrImage).each(function(idx, file){
	        		var reader = new FileReader()

		            reader.onload = function(e) {
		            	var content = $(`<div class='col-md-2 py-3 position-relative'>
		            					<div class='preview-file border p-1 text-center'>
		        							<i class='fas fa-times position-absolute remove-file text-white' data-index='Img-`+counter+`'></i>
											<img src='`+e.target.result+`' class='img-fluid' style='max-height:160px'>
											<div class='file-name'>`+file.name+`</div>
										</div>
									</div>`) 

						container.append(content)
						counter++
		            }

		            reader.readAsDataURL(file)
	        	})
	        }

	        $('body').on('click', '.remove-file', function(){
	        	var param = $(this).attr('data-index')
	        	var fileType = param.split('-')[0]
	        	var index = param.split('-')[1] 

				arrProjectFiles[fileType].splice(index, 1);
				$('i[data-index='+param+']').parents('.preview-file').parent().remove()

				$('i[data-index^='+fileType+'-').each(function(idx, el){
					$(this).attr('data-index', fileType+'-'+idx)
				})

				if(arrProjectFiles['Doc'].length == 0 && arrProjectFiles['Img'].length == 0){
					$('#upload-file-container').removeClass('bg-white')
					$('#upload-file-container .div-placeholder').removeClass('d-none')
				}
	        	console.log(arrProjectFiles)
	        })

	        function removeFile(fileType, index){

	        }
		// ================== UPLOAD FILE ==================
    	CKEDITOR.replace('Project[Detail]', {
			// filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
			// filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',
			// filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
			// filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{csrf_token()}}'
		})
    })
    ";

    $this->registerJs($scriptDetailData, \yii\web\View::POS_END);
?>