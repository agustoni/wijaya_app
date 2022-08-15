$(document).ready(function(){
	$('#pjax-po').on('click', '.btn-received', function(){
		var idPo = $(this).data('idpo')
		console.log('received => '+idPo)
	})

	$('#pjax-po').on('click', '.btn-approved', function(){
		var idPo = $(this).data('idpo')
		console.log('approved => '+idPo)
	})

	$('#pjax-po').on('click', '.btn-print', function(){
		var idPo = $(this).data('idpo')
		console.log('print => '+idPo)
	})
	// $.ajax({
	//     type: 'POST',
	//     url: _url+'backend/purchase-order/submit-po',
	//     data: {dataPoItem},
	//     dataType:'json',
	//     async: true,
	//     beforeSend: function() {
	//         $('#po-create-container').busyLoad('show', {spinner: 'cube',text: 'loading'})
	//     },
	//     success: function(d){
	//         if(d.success){
	//         	var poNum = d.PO.join(', ')
	//         	alert('PO '+poNum+' berhasil dibuat')
	//         	window.location.href = _url+'backend/purchase-order/index';
	//         }else{
	//         	alert(d.message)
	//         }
	//     },
	// }).complete(function(d){
	//     $('#po-create-container').busyLoad('hide')
	//     changePoTotal()
	// })
})