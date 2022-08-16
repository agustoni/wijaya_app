$(document).ready(function(){
	$('body').on('click', '.btn-edit', function(){
		$(this).parents('tr').find('td[class^=datatable_input-]').each(function(){
			// $(this).html()
			editMode($(this))
		})
	})

	function editMode(el){
		if(el.attr('editmode')){
			var value = el.attr('data-value')
			var className = el.attr('class')

			if(className == 'datatable_input-ActionBtn'){
				el.find('button.btn-success').removeClass('d-none')
				el.find('button.btn-edit').addClass('d-none')
				el.find('button.btn-remove').addClass('d-none')
			}else{
				el.empty()

				var input = $(`
    				<input class='form-control `+className+`' value='`+value+`'>
    			`)
    			el.append(input)
			}
		}else{
			if(className == 'datatable_input-ActionBtn'){
				el.find('button.btn-success').addClass('d-none')
				el.find('button.btn-edit').removeClass('d-none')
				el.find('button.btn-remove').removeClass('d-none')
			}
		}
	}

    $('#supplieritem-search').select2();

    $.fn.dataTable.moment( 'MMM D, Y' );
    
    $('#dataTable').DataTable({
        'columnDefs': [
            { 'orderable': false, 'targets': 5 }
          ],
        'aaSorting': []
    })
})