<div class="card card-light mb-3" id="project-payment-container">
    <div class="card-header bg-info text-white p-2">
        <h4 class="card-title m-0">Pembayaran</h4>
    </div>
	<div class="card-body p-2">
		<div class="form-row">
			<div class="col-md-4">
				<label class="font-weight-bold">Tipe Pembayaran</label>
				<select class="form-control payment_input-Instalment" id="paymentType"name="Project[Payment]['PaymentTerm']">
					<option value="">- Tipe Pembayaran -</option>
					<option value="1">50-50</option>
					<option value="2">30-40-30</option>
					<option value="3">Custom</option>
				</select>
			</div>
			<div class="col-md-4">
				<label class="payment_label-Destination font-weight-bold">Bank Tujuan</label>
                <select class="form-control payment_input-Destination" name="Project[Payment]['PaymentTerm']">
					<option value="">- Bank -</option>
					<option value="1">BCA (937310098/Lucky 1)</option>
					<option value="2">BCA (479201233/Lucky 2)</option>
					<option value="3">BRI (028493635/Lucky 3)</option>
				</select>
			</div>
			<div class="col-md-4">
				<label class="font-weight-bold">Total</label><br>
				<input type="hidden" class='form-control' id="payment_input-PaymentNominal" value='250000000'>
				<h3>Rp <?= number_format('250000000', 0, '', '.') ?>
					<span class="payment-checked-true d-none">
						<i class="fas fa-check-circle text-success"></i>
					</span>
					<span class="payment-checked-false d-none">
						<i class="fas fa-times-circle text-danger"></i>
					</span>
				</h3>
				<!-- <input class="form-control" name="Project[Payment]['PaymentTerm']" placeholder="Tipe Pemabayaran. . ."> -->
			</div>
		</div>
		<hr>
		<table class="table table-borderless table-sm" id="form-payment-phase">
			<thead>
				<tr>
					<th>Fase</th>
					<th>Tgl Jatuh Tempo</th>
					<th>Nominal</th>
					<!-- <th>Persen</th> -->
				</tr>
			</thead>
			<tbody id="payment-list">

			</tbody>
			<tbody>
				<tr>
                    <td>
                        <button id="btn-add-payment" class="btn btn-warning" colspan="4">
                            <i class="fas fa-plus text-white"></i>
                        </button>
                    </td>
                    
                </tr>
			</tbody>
		</table>	
	</div>
</div><?php
    $scriptProjectFormPayment = "
    	$('#paymentType').change(function(){
    		$('#payment-list').empty()

    		if($(this).val() == 1){
    			createPaymentPhase(['50', '50'])
    			$('#btn-add-payment').attr('disabled', true)
    		}else if($(this).val() == 2){
    			createPaymentPhase(['30', '40', '30'])
    			$('#btn-add-payment').attr('disabled', true)
    		}else{
    			createPaymentPhase(['100'])
    			$('#btn-add-payment').removeAttr('disabled')
    		}

    		$('.payment_input-Payment').trigger('change')
    	})

    	$('#btn-add-payment').click(function(){
    		var lastNumber = (typeof $('#payment-list').find('tr td:nth-child(1)').last().html() !== 'undefined'? 
                                            parseInt($('#payment-list').find('tr td:nth-child(1)').last().html()) : 0)
    		createPaymentRow(lastNumber)
    	})

    	$('body').on('change keyup', '.payment_input-Payment', function(){
    		var totalPayment = $('#payment_input-PaymentNominal').val()
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

    	function createPaymentRow(idx, paymentPercent=''){
    		var totalPayment = ''
    		if(paymentPercent){
    			var totalPayment = parseInt($('#payment_input-PaymentNominal').val()? $('#payment_input-PaymentNominal').val() : 0) * (parseInt(paymentPercent)/100)
    		}
    		
    		var content = $(`<tr id='payment_row-`+idx+`'>
	    							<td>`+(parseInt(idx)+1)+`</td>
	    							<td>
	    								<input class='form-control payment_input-DueDate'>
	    							</td>
	    							<td>
	    								<input class='form-control payment_input-Payment isNumber' value=`+totalPayment+`>
	    							</td>
	    						 </tr>`)
	    	$('#payment-list').append(content)
    	}
    ";

    $this->registerJs($scriptProjectFormPayment, \yii\web\View::POS_END);
?>