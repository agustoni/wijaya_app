$(document).ready(function(){
    // $('#supplieritem-search').select2()
    $.fn.dataTable.moment( 'MMM D, Y' );
    
    $('#dataTable').DataTable({
        'columnDefs': [
            { 'orderable': false, 'targets': 5 }
        ],
        'aaSorting': []
    })

// ================== AUTOCOMPLETE UoM ==================
    var src = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: _url+'backend/item/get-uom?q=%QUERY',
                    wildcard: '%QUERY'
                }
            })

    $('#item_input-IdUoM').typeahead(null, {
        name: 'uom',
        display: 'UoM',
        source: src
    })

    $('body').on('keyup', '#item_input-IdUoM', function(e){
        if(e.keyCode == 46 || e.keyCode == 8) {
            $('#item_input-IdUoM').typeahead('val','')
            $('#item_input-hidden-IdUoM').val('')
            $('#item_input-hidden-IdUoM').attr('data-text', '')
        }
    })

    $('#item_input-IdUoM').bind('typeahead:select', function(ev, suggestion) {
        if($('#item_input-IdUoM').parents('.twitter-typeahead').length != 0){
            $('#item_input-hidden-IdUoM').val(suggestion.Id)
            $('#item_input-hidden-IdUoM').attr('data-text', suggestion.UoM)
        }
    })

    $('#item_input-IdUoM').bind('typeahead:change', function(ev, suggestion) {
        $('#item_input-IdUoM').typeahead('val', $('#item_input-hidden-IdUoM').attr('data-text'))
    })
// ================== END AUTOCOMPLETE UoM ==================

// ================== SAVE VALIDATION ==================
    $('#save_Item').on('click',function(e){
        var validation = true

        if($('#item_input-hidden-IdUoM').val() == ''){
            validation = false

            $('#item_input-hidden-IdUoM-error').removeClass('d-none')
        }else{
            $('#item_input-hidden-IdUoM-error').addClass('d-none')
        }

        if(!$('#item_input-ItemName').val()){
            validation = false
            var errorLabel = $(`<small class='text-danger error-label'>
                                    Nama item belum diisi
                                </small>`)
            $('#item_input-ItemName').after(errorLabel)
        }else{
            $('#item_input-ItemName').parents('div').find('.error-label').remove()
        }

        if(!$('#item_input-ItemType').val()){
            validation = false
            var errorLabel = $(`<small class='text-danger error-label'>
                                    Tipe item belum diisi
                                </small>`)
            $('#item_input-ItemType').after(errorLabel)
        }else{
            $('#item_input-ItemType').parents('div').find('.error-label').remove()
        }

        if(validation && confirm('Simpan data master item?')){
            var data = {
                IdItem: $('#item_input-ItemName').data('iditem'),
                Name: $('#item_input-ItemName').val(),
                Type: $('#item_input-ItemType').val(),
                IdUoM: $('#item_input-hidden-IdUoM').val(),
                Description: $('#item_input-Description').val()
            }

            $.ajax({
                type: 'POST',
                url: _url+'backend/item/save-item',
                data: data,
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
                        }else if(actionId == 'create-item'){
                            alert('data berhasil dibuat')
                            $('#item-master-container .card-body :input').val('')
                        }
                    }
                },
            }).complete(function(d){
                $('#layoutSidenav_content').busyLoad('hide')
            })
        }
    })
// ================== SAVE VALIDATION ==================
})