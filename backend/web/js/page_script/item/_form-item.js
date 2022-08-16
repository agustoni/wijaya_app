$(document).ready(function(){

// ================== AUTOCOMPLETE UoM ==================
    $('body').on('keyup', '#item_input-IdUoM', function(e){
        if($('#item_input-IdUoM').parents('.twitter-typeahead').length == 0){
            $('#item_input-hidden-NewUoM').val($(this).val())
        }else{
            if(e.keyCode == 46 || e.keyCode == 8) {
                $('#item_input-IdUoM').typeahead('val','')
                $('#item_input-hidden-IdUoM').val('')
                $('#item_input-hidden-IdUoM').attr('data-text', '')
            }
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

    $('.toggle-search-uom').click(function(){
        var child = $(this).children()
        if(child.attr('class') == 'fas fa-toggle-on'){
            child.attr('class', 'fas fa-toggle-off')

            $('#item_input-IdUoM').typeahead('destroy')
        }else if(child.attr('class') == 'fas fa-toggle-off'){
            child.attr('class', 'fas fa-toggle-on')

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
        }

        $('#item_input-IdUoM').val('')
        $('#item_input-hidden-NewUoM').val('')
        $('#item_input-hidden-IdUoM').val('')
    })
// ================== END AUTOCOMPLETE UoM ==================

// ================== SAVE VALIDATION ==================
    $('#save_Item').on('click',function(e){
        var validation = true

        if($('#item_input-hidden-IdUoM').val() == '' && $('#item_input-hidden-NewUoM').val() == ''){
            validation = false

            if($('.toggle-search-uom').find('i').hasClass('fa-toggle-on')){
                $('#item_input-hidden-IdUoM-error').removeClass('d-none')
            }else{
                $('#item_input-hidden-NewUoM-error').removeClass('d-none')
            }
        }else{
            $('#item_input-hidden-IdUoM-error').addClass('d-none')
            $('#item_input-hidden-NewUoM-error').addClass('d-none')
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
                NewUoM: $('#item_input-hidden-NewUoM').val(),
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
                        }else if(actionId == 'create'){
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