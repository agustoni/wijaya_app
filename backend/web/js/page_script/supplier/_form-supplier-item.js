$(document).ready(function(){
	$('.supplier_item-IdItem').select2({
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

	// $('.supplier_item-IdItem').on('select2:select', function (e) {
	//  	var selected = e.params.data

	//  	console.log('supplier item select2')
	//  	console.log(selected)

	 	// $('.select2-itemlist-input').val(null).trigger('change')
	// })

	$('.btn-add-supplier-item').click(function(){
		if(!$('.supplier_item-IdItem').val()){
			alert('item belum dipilih')
			return false
		}

		var data = $('.supplier_item-IdItem').select2('data')
		var itemName = data[0].text
		var idItem = $('.supplier_item-IdItem').val()
		var stock = $('.supplier_item-Stock').val()? $('.supplier_item-Stock').val() : 0
		var stocksupplier = 1
		var btnEdit = `<button class="btn btn-sm btn-info btn-edit">
            						<i class="fas fa-pencil-alt"></i>
            					</button>`

		if(confirm('tambah item "'+itemName+'" ?')){
			var t = $('#dtb-supplier-item').DataTable()
			var counter = t.rows().count() + 1

			t.row.add([counter, itemName, stocksupplier+"/"+stock, btnEdit]).draw(false);
		}

		// console.log('idItem = '+idItem)
		// console.log('idSupplier = '+idSupplier)

		// $('.supplier_item-IdItem').val('').trigger('change')
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

	$.fn.dataTable.moment( 'MMM D, Y' );
    $('#dtb-supplier-item').DataTable({
        'columnDefs': [
            { 'orderable': false, 'targets': 3}
          ],
        'aaSorting': []
    })
})