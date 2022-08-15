var host = window.location.host;
if(host == 'localhost'){
    _url = window.location.protocol + "//" + window.location.host + "/" + window.location.pathname.split('/')[1] + "/"
}else{
    _url = window.location.protocol + "//" + window.location.host + "/"
}

$(document).ready(function(){
// ========= FOR UPDATE DATA =========  
    function updateData(dataProject){
        // ========= _form-client =========
            $('#projectclient_input-Company').val(dataProject.Client.Company)
            $('#projectclient_input-Address').val(dataProject.Client.Address)

            //create contact row
            $.each(dataProject.Client.Contact, function(idx, val){
                var contactLastNumber = (typeof $('#project-contact-list div:nth-child(1) label').last().html() !== 'undefined'? parseInt($('#project-contact-list div:nth-child(1) label').last().html()) : 0)

                createContactRow(contactLastNumber, val.Id, val.Name, val.Title, val.Role, val.Phone, val.Email)
            })
        // ========= END _form-client =========

        // ========= _form-detail => _detail-data =========
            $('.project_detail_input-IdProjectType').val(dataProject.Detail.IdProjectType)
            CKEDITOR.instances['Project[Detail][DetailDescription]'].setData(dataProject.Detail.DetailDescription)
        // ========= END _form-detail => _detail-data =========

        // ========= _form-detail => _detail-data->File =========
            // asdasdasdasds
            // asdasdasdasds
        // ========= END _form-detail => _detail-data->File =========

        // ========= _form-detail => _detail-item =========
            $.each(dataProject.DetailItem, function(idx, prd){
                createProduct(prd, prd.Total.Cost, prd.Total.Margin, prd.Total.Price)
            })
        // ========= END _form-detail => _detail-item =========

        // ========= _form-detail => _detail-worker =========
            $.each(dataProject.Worker, function(idx, worker){
                var lastNumber = (typeof $('#worker-list tr td:nth-child(1)').last().html() !== 'undefined'? parseInt($('#worker-list tr td:nth-child(1)').last().html()) : 0)

                createWorkerRow(lastNumber, worker.Id, worker.Name, worker.Role, worker.StartAt, worker.StatusDate)
            })
        // ========= END _form-detail => _detail-worker =========

        // ========= _form-payment =========
            $('#payment_input-PaymentAmount').val(dataProject.Payment.Amount)
            $('.payment_label-PaymentAmount').html('Rp '+numberFormat('', dataProject.Payment.Amount))

            if(dataProject.Payment.IdPaymentDestination){
                $('.payment_input-IdPaymentDestination').val(dataProject.Payment.IdPaymentDestination)   
                $('.payment_input-IdPaymentDestination').attr('readonly',true)
            }
            
            if($('#paymentInstallment').val(dataProject.Payment.Installment)){
                $('#paymentInstallment').val(dataProject.Payment.Installment)
                $('#paymentInstallment').attr('readonly',true)
            }

            $.each(dataProject.Payment.PaymentPhase, function(idx, val){
                createPaymentRow(idx, '', val.IdPayment, val.PayoutPhase, val.DueDate, val.PaymentNominal, val.PaymentDate, val.Status)
            })

        // ========= END _form-payment =========
    }
// ========= END FOR UPDATE DATA =========

// ========= INITIAL FUNCTION =========
    $('#smartwizard').smartWizard({
        // selected: 1,
        theme: 'arrows',
        transition: {
            animation: 'fade'
        },
        justified: true,
        enableURLhash: true,
        autoAdjustHeight: false,
        keyboardSettings: {
            keyNavigation: false, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
        },
        anchorSettings: {
            enableAllAnchors: true, // Activates all anchors clickable all times
            markDoneStep: false, // Add done state on navigation
        },
        toolbarSettings:{
            toolbarExtraButtons: [
                $('<button></button>')
                    .text('Finish')
                    .addClass('btn btn-success')
                    .attr('id', 'btn-submit-form')
                    .attr('style', 'display:none')
                    .attr('type', 'button')
            ]
        }
    })

    // Initialize the leaveStep event
    // $('#smartwizard').on('leaveStep', function(e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {
    //     if(currentStepIndex == 0){
    //         console.log('client --> detail')
    //     }else if(currentStepIndex == 1){
    //         console.log('detail --> payment')
    //     }else{

    //     }
    // })

    $('#smartwizard').on('showStep', function(e, anchorObject, stepIndex, stepDirection) {
        if(stepIndex == 2 && stepDirection == 'forward'){
            $('.sw-btn-next').hide()
            $('#btn-submit-form').show()
        }else{
            $('.sw-btn-next').show()
            $('#btn-submit-form').hide()
        }
    })

    /*************** FIRST FUNCTION ***************/
    $(window).on('load', function(){
        if(actionId == 'create'){
            console.log('create data')
            
            // dataProject.Client = {}
            // dataProject.Detail = {}
            // dataProject.DetailItem = {}
            // dataProject.Worker = {}
            // dataProject.Payment = {}

            //FIRST ACTION ON CREATE
            createContactRow(0)
        }else if(actionId == 'view'){
            console.log('view data')
            // dataProject = ".(isset($dataProject)? $dataProject : '')."
            
            // render data
            updateData(dataProject)
        }
    })

    console.log('=========================')
    console.log(dataProject)
    /*************** END FIRST FUNCTION ***************/
// ========= END INITIAL FUNCTION =========

// ========= _FORM CLIENT =========
    $('#btn-add-contact').click(function(){
        var lastNumber = (typeof $('#project-contact-list div:nth-child(1) label').last().html() !== 'undefined'? parseInt($('#project-contact-list div:nth-child(1) label').last().html()) : 0)

        createContactRow(lastNumber)
    })

    $('body').on('click', '.projectcontact_remove-contact', function(){
        // var rowNum = $(this).parents('div[id^=contact_row-]').attr('id').split('-').pop()
        var idProjectContact = $(this).attr('data-idcontact')
        console.log(idProjectContact)
        
        if(idProjectContact == ''){
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
            url: _url+'backend/project/delete-project-contact',
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

    function createContactRow(lastNumber, IdProjectContact = '', Name = '', Position = '', Phone = '', Email = ''){
        var contactRowContent = $(`<div class='form-row mb-2' id='contact_row-`+lastNumber+`'>
                                        <div class='col-md-1 my-auto text-center'>
                                            <label class='font-weight-bold'>`+(lastNumber + 1)+`</label>
                                        </div>
                                        <div class='col-md-2 my-auto text-center'>
                                            <input type='text' class='form-control projectcontact_input-Name' name='Project[Contact][`+lastNumber+`][Name]' placeholder='Nama. . .' autocomplete='off' value='`+Name+`'>
                                        </div>
                                        <div class='col-md-2 my-auto text-center'>
                                            <input type='text' class='form-control projectcontact_input-Position' name='Project[Contact][`+lastNumber+`][Title]' placeholder='Jabatan. . .' autocomplete='off' value='`+Position+`'>
                                        </div>
                                        <div class='col-md-2 my-auto text-center'>
                                            <input type='text' class='form-control projectcontact_input-Phone' name='Project[Contact][`+lastNumber+`][Phone]' placeholder='Phone. . .' autocomplete='off' value='`+Phone+`'>
                                        </div>
                                        <div class='col-md-2 my-auto text-center'>
                                            <input type='text' class='form-control projectcontact_input-Email' name='Project[Contact][`+lastNumber+`][Email]' placeholder='Email. . .' autocomplete='off' value='`+Email+`'>
                                        </div>
                                        <div class='col-md-1 my-auto text-center'>
                                            <button type='button' class='btn btn-danger projectcontact_remove-contact' data-idcontact='`+IdProjectContact+`'>
                                                <i class='fas fa-times'></i>
                                            </button>
                                        </div>
                                   </div>
        `)

        $('#project-contact-list').append(contactRowContent)
    }
// ========= END FORM CLIENT =========

// ========= _FORM DETAIL =========
    // ********** DETAIL DATA **********
        $('body').click(function(e) {
            if (e.target.id == 'upload-file-container' || $(e.target).parents('#upload-file-container').length) {
                $('#upload-file-container').addClass('focus')
            } else {
                $('#upload-file-container').removeClass('focus')
            }
        })
    
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
        })

        function removeFile(fileType, index){

        }

        CKEDITOR.replace('Project[Detail][DetailDescription]', {
            // filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            // filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',
            // filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            // filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token={{csrf_token()}}'
        })

        $('.datepicker').datepicker({
            // minDate: 0,
            dateFormat: 'dd-mm-yy'
        })
    // ********** END DETAIL DATA **********

    // ********** DETAIL ITEM **********
        $('.select2-product-input').select2({
            ajax: {
                url: _url+'backend/project/get-all-product',
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

            $('.select2-product-input').val(null).trigger('change')
            createProduct(selected)
        })

        function createProduct(data, TotalCost='', TotalMargin='', TotalPrice=''){
            $('#form-project-product .nav-link').removeClass('active')
            $('#form-project-product .tab-pane').removeClass('active')

            var x = $('#form-project-product .nav-tabs .list-tab-product').length
            var productName = 'Produk '+(parseInt(x)+1)
            var tab = $(`<li class='nav-item'>
                            <a class='nav-link active list-tab-product' data-toggle='tab' href='#product_`+x+`'>`+productName+`</a>
                        </li>`)

            var tabContent = $(`<div id='product_`+x+`' class='tab-pane active' data-idproduct='`+data.id+`'>
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
                                                    <label class='product_label-TotalCost'></label>
                                                    <input type='hidden' class='form-control product_input-TotalCost text-right'>
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
                $(tabContent).find('tbody').append(createProductItem(i, false, val.IdItem, val.ItemName, val.Qty, val.UoM, val.Cost, val.StatusExp, val.LastUpdated, val.IdSupplier))
            })

            if(TotalMargin != ''){
                $(tabContent).find('.product_input-TotalMargin').val(TotalMargin)
                $(tabContent).find('.product_label-TotalMargin').html(numberFormat('', TotalMargin))
            }

            $(tab).insertBefore('#nav-tab-summary')
            $(tabContent).insertBefore('#tab-content-summary')

            calcTotal()
        }

        function createProductItem(i, inputSelect, IdItem='', ItemName='', Qty='', UoM='-', Cost='0', StatusExp='', LastUpdated='', IdSupplier=''){
            var statusAlert = ''
            var lastUpdate = ''

            if(!inputSelect){
                var inputItem = $(`<label class='product_label-Item'>`+ItemName+`</label>
                                <input type='' class='form-control product_input-IdItem' value='`+IdItem+`' placeholder='supposed to be hidden'>`)
            }else{
                var inputItem = $(`<input class='form-control product_input-Item' placeholder='Item. . .'>
                                    <input type='' class='form-control product_input-IdItem' value='' placeholder='supposed to be hidden'>`)
            }

            if(StatusExp == 0){
                statusAlert = 'style=background-color:#fdd8d8'
                lastUpdate = LastUpdated
            }

            var totalCost = parseInt(Qty? Qty : 0) * parseInt(Cost? Cost : 0)

            var tabContentItem = $(`<tr class='item_row-`+i+`' `+statusAlert+`>
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
                                            <input type='text' class='form-control product_input-Cost calc text-right isNumber' value='`+totalCost+`' data-Cost='`+Cost+`' data-idsupplier='`+IdSupplier+`'>
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

        $('body').on('click', '#nav-tab-summary', function(){
            $('.table-summary tbody').find('tr').not('#empty-summary').remove()

            var grandTotalCost = 0
            var grandTotalMargin = 0
            var grandTotalPrice = 0

            $('.tab-content div[id^=product_]').each(function(idx){
                var productName = $(this).find('.product_label-ProductName').html()
                var productTotalCost = $(this).find('.product_input-TotalCost').val()
                var productTotalPrice = $(this).find('.product_input-TotalPrice').val()
                var productTotalMargin = ($(this).find('.product_input-TotalMargin').val() ? $(this).find('.product_input-TotalMargin').val() : 0)

                var summaryTbody = $(`<tr>
                                        <td>`+(parseInt(idx)+1)+`</td>
                                        <td>`+productName+`</td>
                                        <td>`+numberFormat('Rp ', productTotalCost)+`</td>
                                        <td>`+numberFormat('Rp ', productTotalPrice)+`</td>
                                        <td>`+numberFormat('Rp ', productTotalMargin)+`</td>
                                      </tr>`)
                $('.table-summary tbody').append(summaryTbody)

                grandTotalCost += parseInt(productTotalCost)
                grandTotalMargin += parseInt((productTotalMargin ? productTotalMargin : 0))
                grandTotalPrice += parseInt(productTotalPrice)
            })

            // create summary tfoot
                if(grandTotalCost > 0 || grandTotalCost > 0 || grandTotalCost > 0){
                    $('.table-summary tfoot').removeClass('d-none')
                    $('#empty-summary').addClass('d-none')

                    $('.table-summary tfoot .product-total-cost').html(numberFormat('Rp ', grandTotalCost))
                    $('.table-summary tfoot .product-total-price').html(numberFormat('Rp ', grandTotalPrice))
                    $('.table-summary tfoot .product-total-margin').html(numberFormat('Rp ', grandTotalMargin))
                }else{
                    $('.table-summary tfoot').addClass('d-none')
                    $('#empty-summary').removeClass('d-none')
                }
            // END create summary tfoot
        })

        $('body').on('click', '.add-product-item', function(){
            var parentTabProduct = $(this).parents('#form-project-product .tab-pane.active')
            var lastNumber = (typeof $(parentTabProduct).find('.table-product-item tbody tr td:nth-child(1)').last().html() !== 'undefined'? 
                                        parseInt($(parentTabProduct).find('.table-product-item tbody tr td:nth-child(1)').last().html()) 
                                        : 0)

            $(parentTabProduct).find('table tbody').append(createProductItem(lastNumber, 1))
            itemTypeaheadInit($(parentTabProduct).find('.item_row-'+lastNumber+' .product_input-Item'))
        })

        $('body').on('keyup', '.product_input-Item', function(e){
            if(e.keyCode == 46 || e.keyCode == 8) {
                $(this).parents(`tr[class^='item_row-']`).find('.product_input-Item').typeahead('val', '')
                $(this).parents(`tr[class^='item_row-']`).find('.product_input-IdItem').val('')
                $(this).parents(`tr[class^='item_row-']`).find('.product_label-UoM').text('-')
            }
        })

        $('body').on('typeahead:change', '.product_input-Item', function(ev, suggestion) {
            var itemName = $(this).parents('tr').find('.product_input-IdItem').attr('data-text')
            $(this).parents(`tr[class^='item_row-']`).find('.product_input-Item').typeahead('val', itemName)
        })

        $('body').on('typeahead:select', '.product_input-Item', function(ev, suggestion) {
            if($('.product_input-IdItem[value='+suggestion.IdItem+']').length == 0){
                $(this).parents(`tr[class^='item_row-']`).find('.product_input-IdItem').val(suggestion.IdItem)
                $(this).parents(`tr[class^='item_row-']`).find('.product_input-IdItem').attr('value', suggestion.IdItem)
                $(this).parents(`tr[class^='item_row-']`).find('.product_input-IdItem').attr('data-text', suggestion.Name)
                $(this).parents(`tr[class^='item_row-']`).find('.product_label-UoM').text(suggestion.UoM)
                $(this).parents(`tr[class^='item_row-']`).find('.product_input-Qty').attr('value', 1)
                $(this).parents(`tr[class^='item_row-']`).find('.product_label-Cost').html(numberFormat('Rp', suggestion.Cost))
                $(this).parents(`tr[class^='item_row-']`).find('.product_input-Cost').val(suggestion.Cost)
                $(this).parents(`tr[class^='item_row-']`).find('.product_input-Cost').attr('value', suggestion.Cost)
                $(this).parents(`tr[class^='item_row-']`).find('.product_input-Cost').attr('data-cost', suggestion.Cost)

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
                    url: _url+'backend/project/get-sales-item?q=%QUERY',
                    wildcard: '%QUERY'
                }
            })

            inputTypeahead.typeahead(null, {
                name: 'name',
                display: 'Name',
                source: src
            })
        }

        $('body').on('keyup', '.product_input-TotalMargin', function(){
            $('.product_input-TotaPercent').val('')
            calcTotal()
        })

        $('body').on('keyup', '.product_input-TotaPercent', function(){
            $('.product_input-TotalMargin').val('')
            calcTotal()
        })

        function calcTotal(){
            $('.tab-content div[id^=product_]').each(function(){
                var marginPercent = parseInt($(this).find('.product_input-TotaPercent').val()? $(this).find('.product_input-TotaPercent').val() : 0)
                var grandTotalMargin = parseInt($(this).find('.product_input-TotalMargin').val()? parseInt($(this).find('.product_input-TotalMargin').val()) : 0)
                var grandTotalPrice = 0
                var grandTotalCost = 0

                $(this).find('.product_input-Cost').each(function(idx, val){
                    grandTotalCost += parseInt($(this).val())
                })

                if($(this).find('.product_input-TotaPercent').val()){
                    grandTotalMargin = grandTotalCost * (marginPercent/100)
                }

                grandTotalPrice = grandTotalCost + grandTotalMargin

                $(this).find('.product_input-TotalCost').val(grandTotalCost)
                $(this).find('.product_input-TotalPrice').val(grandTotalPrice)

                $(this).find('.product_label-TotalCost').html(numberFormat('', grandTotalCost))
                // $(this).find('.product_label-TotalMargin').html(numberFormat('', grandTotalMargin))
                $(this).find('.product_label-TotalPrice').html(numberFormat('', grandTotalPrice))

                $(this).find('.product_input-TotalCost').html(numberFormat('', grandTotalCost))
                $(this).find('.product_input-TotalMargin').html(numberFormat('', grandTotalMargin))
                $(this).find('.product_input-TotalPrice').html(numberFormat('', grandTotalPrice))
            })
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
    
        $('body').on('keypress', '.isNumber', function (evt){
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;

            if (charCode != 46 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        })

        $('body').on('click', '.product_removeitem', function(){
            var parentEl = $(this).parents('tbody')
            if($(parentEl).find(`tr[class^='item_row-']`).length > 1){
                $(this).parents('tr').remove()

                $(parentEl).find(`tr[class^='item_row-']`).each(function(x){
                    $(this).attr('class', 'item_row-'+x)
                    $(this).find('td:nth-child(1)').html(parseInt(x)+1)
                })
            }else{
                $(this).parents(`tr`).find(':input').val('')
                $(this).parents(`tr`).removeAttr('style')
                $(this).parents(`tr`).find('.item_input-IdItem').attr('value', '')
                $(this).parents(`tr`).find('.item_input-IdItem').attr('data-text', '')
            }

            $('.calc').trigger('keyup')
        })
    // ********** END DETAIL ITEM **********

    // ********** DETAIL WORKER **********
        var workerRole = ['Pekerja', 'Sales', 'Koordinator']
        var srcSearchWorker = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: _url+'backend/project/get-worker?q=%QUERY',
                wildcard: '%QUERY'
            }
        })

        $('#search-worker').typeahead(null, {
            name: 'name',
            display: 'Name',
            source: srcSearchWorker
        })

        $('body').on('typeahead:select', '#search-worker', function(ev, suggestion) {
            $(this).typeahead('val', '')
            if($('.worker_input-IdWorker[value='+suggestion.Id+']').length == 0){
                var lastNumber = (typeof $('#worker-list tr td:nth-child(1)').last().html() !== 'undefined'? parseInt($('#worker-list tr td:nth-child(1)').last().html()) : 0)

                createWorkerRow(lastNumber, suggestion.Id, suggestion.Name)
            }else{
                alert('pekerja sudah dipilih sebelumnya')
            }   
        })

        $('body').on('click', '.worker_remove', function(){
            $(this).parents('tr').remove()

            $(`tr[id^='worker_row-']`).each(function(x){
                $(this).find('td:nth-child(1)').html(parseInt(x)+1)

                $(this).find(`:input[name^='ProjectWorker']`).each(function(){
                    var name = $(this).attr('name').split(/[[\]]{1,2}/)
                    
                    $(this).attr('name', 'ProjectWorker['+x+']['+name[2]+']')
                })
            })
        })

        // $('#btn-add-worker').click(function(){
        //     var lastNumber = (typeof $('#worker-list tr td:nth-child(1)').last().html() !== 'undefined'? parseInt($('#worker-list tr td:nth-child(1)').last().html()) : 0)

        //     createWorkerRow(lastNumber)
        // })

        function createWorkerRow(lastNumber, idWorker = '', name = '', role = '', startAt = '', statusDate=''){
            var optionRole = ''

            $(workerRole).each(function(idx, val){
                optionRole += `<option value='`+val+`' `+(role == val? 'selected' : '')+`>`+val+`</option>`
            })

            var workerContent = $(`<tr id='worker_row-`+lastNumber+`'>
                                    <td>`+parseInt(lastNumber+1)+`</td>
                                    <td>
                                        <span class='worker_input-Name'>`+name+`</span>
                                        <input type='hidden' class='form-control worker_input-IdWorker' name='ProjectWorker[`+lastNumber+`][IdWorker]' value='`+idWorker+`'>
                                    </td>
                                    <td>
                                        <select class='form-control worker_input-Role' name='ProjectWorker[`+lastNumber+`][Role]'>
                                            <option value=''>- Role -</option>
                                            `+optionRole+`
                                        </select> 
                                    </td>
                                    <td>
                                        <input class='form-control worker_input-StartAt datepicker' name='ProjectItem[`+lastNumber+`][StartAt]' placeholder='Mulai bekerja. . .'>
                                        <!-- value='`+startAt+`' `+(statusDate == 0? 'readonly' : '')+` -->
                                    </td>
                                    <td>
                                        <button type='button' class='btn btn-danger worker_remove'>
                                            <i class='fas fa-times'></i>
                                        </button>
                                    </td>
                                </tr>`)

            $('#form-worker-list #worker-list').append(workerContent)
            $(workerContent).find('.datepicker').datepicker({
                // minDate: 0,
                dateFormat: 'dd-mm-yy'
            })
        }
    // ********** END DETAIL WORKER **********
// ========= END _FORM DETAIL =========

// ========= _FORM PAYMENT =========
    $('#paymentInstalment').change(function(){
        $('#payment-list').empty()

        if($(this).val() == '50-50'){
            createPaymentPhase(['50', '50'])
            $('#btn-add-payment').attr('disabled', true)
        }else if($(this).val() == '50-30-20'){
            createPaymentPhase(['50', '30', '20'])
            $('#btn-add-payment').attr('disabled', true)
        }else{
            createPaymentPhase(['100'])
            $('#btn-add-payment').removeAttr('disabled')
        }

        $('.payment_input-Payment').trigger('change')
    })

    $('#btn-add-payment').click(function(){
        var lastNumber = (typeof $('#payment-list').find('tr td:nth-child(1) span').last().html() !== 'undefined'? 
                                        parseInt($('#payment-list').find('tr td:nth-child(1) span').last().html()) : 0)
        createPaymentRow(lastNumber)
    })

    $('body').on('change keyup', '.payment_input-Payment', function(){
        var totalPayment = $('#ppaymentAmount').val()
        var checkPaymentTotal = 0

        $('.payment_input-Payment').each(function(){
            checkPaymentTotal += parseInt($(this).val()? $(this).val() : 0)
        })

        if(checkPaymentTotal == totalPayment){
            $('.payment-checked-false').addClass('d-none')
            $('.payment-checked-true').removeClass('d-none')

            $('.payment-checked-false').parents('h3').removeClass('text-danger')
        }else if(checkPaymentTotal < totalPayment || checkPaymentTotal > totalPayment){
            $('.payment-checked-false').removeClass('d-none')
            $('.payment-checked-true').addClass('d-none')

            $('.payment-checked-false').parents('h3').addClass('text-danger')
        }
    })

    $('body').on('keypress', '.isNumber', function (evt){
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;

        if (charCode != 46 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    })

    function createPaymentPhase(phase=''){
        $.each(phase, function(idx, val){
            createPaymentRow(idx, val)
        })
    }

    function createPaymentRow(idx, paymentPercent='', idPayment='', payoutPhase='', dueDate='', paymentNominal='', paymentDate='', status=0){
        var totalPayment = paymentNominal
        if(paymentNominal == ''){
            if(paymentPercent){
                var totalPayment = parseInt($('#paymentAmount').val()? $('#paymentAmount').val() : 0) * (parseInt(paymentPercent)/100)
            }
        }
        
        var content = $(`<tr id='payment_row-`+idx+`'>
                                <td class='text-center'>
                                    <span class='payment_label-PayoutPhase'>`+(payoutPhase == '' ? parseInt(idx)+1 : payoutPhase)+`</span>
                                    <input type='hidden' class='form-control payment_input-IdPayment' value='`+idPayment+`'>
                                </td>
                                <td>
                                    <input class='form-control datepicker payment_input-DueDate' value='`+dueDate+`'>
                                    <small class='payment_label-PaymentDate text-primary'></small>
                                </td>
                                <td>
                                    <input class='form-control payment_input-Payment isNumber' value=`+totalPayment+`>
                                </td>
                             </tr>`)

        if(status == 1){
            $(content).find(':input').attr('readonly', true)
            $(content).find('.payment_label-PaymentDate').html('Paid: '+paymentDate)
        }

        $('#payment-list').append(content)
        $(content).find('.datepicker').datepicker({
            // minDate: 0,
            dateFormat: 'dd-mm-yy'
        })

        if(idPayment != ''){
            $(content).find(':input').trigger('change')
        }
    }
// ========= END _FORM PAYMENT =========

// ========= SUBMIT FORM =========
    $('#btn-submit-form').click(function(){
        // getClientData()
        // getDetailProject()
        // getDetailItem()
        // getWorker()
        // getPayment()

        // dataProject.ProjectItem = {}
        // dataProject.ProjectAmount = {}
        // dataProject.ProjectPayment = {}
        // dataProject.ProjectWorker = {}
        // dataProject.ProjectFile = {}

        if(!getProjectData()){
            console.log('getProjectData ==> false')
            return false
        }

        if(!getProjectClientData()){
            console.log('getProjectClientData ==> false')
            return false
        }

        if(!getProjectDetailData()){
            console.log('getProjectDetailData ==> false')
            return false
        }

        if(!getProjectItemData()){
            console.log('getProjectItemData ==> false')
            return false
        }

        
        console.log('=========================')
        console.log('FINISH')
        console.log(dataProject)

        return false
        
        if(confirm('submit data project?')){
            var form_data = new FormData()

            $.each(dataProject.Detail.DetailFiles, function(type, files){
                $.each(files, function(idx, file){
                    form_data.append(type+'_'+idx, file);
                })
            })

            form_data.append('data', JSON.stringify(dataProject))

            $.ajax({
                type: 'POST',
                url: _url+'backend/project/save-project',
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                dataType:'json',
                async: true,
                beforeSend: function() {
                    $('#layoutSidenav_content').busyLoad('show', {spinner: 'cube',text: 'loading'})
                },
                success: function(d){
                   console.log('done')
                },
            }).complete(function(d){
                $('#layoutSidenav_content').busyLoad('hide')
            })
        }
    })

    function getProjectData(){
        var startDate = ($(".project_detail_input-StartDate").val()? $(".project_detail_input-StartDate").val() : null)
        var endDate = ($(".project_detail_input-EndDate").val()? $(".project_detail_input-EndDate").val() : null)

        if(startDate && endDate){
            if(startDate > endDate){
                alert('periode tanggal project salah, tgl start lebih besar dari tgl end')
                return false
            }
        }

        dataProject.Project = {}
        dataProject.Project = {
            StartDate: ($(".project_detail_input-StartDate").val()? $(".project_detail_input-StartDate").val() : null),
            EndDate: ($(".project_detail_input-EndDate").val()? $(".project_detail_input-EndDate").val() : null)
        }

        return true
    }

    function getProjectClientData(){
        var arrContact = {}

        $("#project-contact-list").find("div[id^='contact_row-']").each(function(idx){
            arrContact[idx] = {}

            arrContact[idx]["Name"] = ($(this).find('.projectcontact_input-Name').val()? $(this).find('.projectcontact_input-Name').val() : null)
            arrContact[idx]["Position"] = ($(this).find('.projectcontact_input-Position').val()? $(this).find('.projectcontact_input-Position').val() : null)
            arrContact[idx]["Phone"] = ($(this).find('.projectcontact_input-Phone').val()? $(this).find('.projectcontact_input-Phone').val() : null)
            arrContact[idx]["Email"] = ($(this).find('.projectcontact_input-Email').val()? $(this).find('.projectcontact_input-Email').val() : null)
        })

        dataProject.ProjectClient = {}
        dataProject.ProjectClient = {
            Company: ($("#projectclient_input-Company").val()? $("#projectclient_input-Company").val() : null),
            Address: ($("#projectclient_input-Address").val()? $("#projectclient_input-Address").val() : null),
            Contact: arrContact
        }

        return true
    }

    function getProjectDetailData(){
        dataProject.ProjectDetail = {
            IdProjectType: ($('.project_detail_input-IdProjectType').val()? $('.project_detail_input-IdProjectType').val() : null),
            Detail: ((CKEDITOR.instances['Project[Detail][DetailDescription]'].getData())? (CKEDITOR.instances['Project[Detail][DetailDescription]'].getData()) : null)
        }

        return true
    }

    function getProjectItemData(){
        dataProject.ProjectItem = {}

        $('.tab-content div[id^=product_]').each(function(idRow){
            var idProduct = $(this).attr('data-idproduct')
            $(this).find('tbody tr').not('button').each(function(x){
                if(typeof dataProject.ProjectItem[idRow] === 'undefined') {
                    dataProject.ProjectItem[idRow] = {}
                    // dataProject.ProjectItem[idRow]['IdProduct'] = {}
                    dataProject.ProjectItem[idRow]['IdProduct'] = idProduct
                    dataProject.ProjectItem[idRow]['Listitem'] = {}
                    dataProject.ProjectItem[idRow]['Listitem'][x] = {}
                }

                dataProject.ProjectItem[idRow]['Listitem'][x] = {
                    IdItem: ($(this).find('.product_input-IdItem').val()? $(this).find('.product_input-IdItem').val() : null),
                    IdSupplier: ($(this).find('.product_input-Cost').attr('data-idsupplier')? $(this).find('.product_input-Cost').attr('data-idsupplier') : null),
                    Qty: ($(this).find('.product_input-Qty').val()? $(this).find('.product_input-Qty').val() : null),
                    Cost: ($(this).find('.product_input-Cost').attr('data-cost')? $(this).find('.product_input-Cost').attr('data-cost') : null),
                    Description: ($(this).find('.product_input-Description').val()? $(this).find('.product_input-Description').val() : null),
                }

            })
        })

        return true
    }

/* ******************************************************************************************************* */
    
    
// ========= SUBMIT FORM =========
})