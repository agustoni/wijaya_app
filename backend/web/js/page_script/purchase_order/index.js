$(document).ready(function(){
	$('.datepicker').datepicker({
        dateFormat: 'dd-mm-yy'
    })

	$('#pjax-po').on('click', '.btn-approved', function(){
		if(confirm('PO Disetujui?')){
			var idPo = $(this).data('idpo')

			$.ajax({
	            type: 'POST',
	            url: _url+'backend/purchase-order/approve-po',
	            data: {idPo},
	            dataType:'json',
	            async: true,
	            beforeSend: function() {
	                $('.purchase-order-index').busyLoad('show', {spinner: 'cube',text: 'loading'})
	            },
	            success: function(d){
	                if(d.success){
	                	$.pjax.reload('#pjax-po')
	                	// $.pjax({container: '#pjax-po'})
	                }else{
	                	alert(d.message)
	                }
	            },
	        }).complete(function(d){
	            $('.purchase-order-index').busyLoad('hide')
	        })
		}
	})

	$('#pjax-po').on('click', '.btn-received', function(){
		if(confirm('PO Sudah diterima?')){
			var idPo = $(this).data('idpo')

			$.ajax({
	            type: 'POST',
	            url: _url+'backend/purchase-order/receive-po',
	            data: {idPo},
	            dataType:'json',
	            async: true,
	            beforeSend: function() {
	                $('.purchase-order-index').busyLoad('show', {spinner: 'cube',text: 'loading'})
	            },
	            success: function(d){
	                if(d.success){
	                	$.pjax.reload('#pjax-po')
	                }else{
	                	alert(d.message)
	                }
	            },
	        }).complete(function(d){
	            $('.purchase-order-index').busyLoad('hide')
	        })
		}
	})
})