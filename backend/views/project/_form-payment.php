<div class="card card-light mb-3" id="project-payment-container">
    <div class="card-header bg-info text-white p-2">
        <h4 class="card-title m-0">Pembayaran</h4>
    </div>
	<div class="card-body p-2">
		<div class="form-row">
			<div class="col-md-6">
				<label class="font-weight-bold">Tipe Pembayaran</label>
				<select class="form-control" name="Project[Payment]['PaymentTerm']">
					<option value="">- Tipe Pembayaran -</option>
					<option value="1">Tipe 1</option>
					<option value="1">Tipe 2</option>
					<option value="1">Tipe 3</option>
				</select>
			</div>
			<div class="col-md-6">
				<label class="font-weight-bold">Tipe Pembayaran</label>
				<input class="form-control" name="Project[Payment]['PaymentTerm']" placeholder="Tipe Pemabayaran. . .">
			</div>
			<div class="col-md-6">
				<label class="payment_label-TotalPayment font-weight-bold">Rp 0</label>
                <input type="hidden" class="form-control payment_input-TotalPayment" value="0">
			</div>
		</div>
		<table class="table table-borderless table-sm" id="form-payment-phase">
			<thead>
				<tr>
					<th>Fase Pembayaran</th>
					<th>Tgl Jatuh Tempo</th>
					<th>Nominal</th>
					<th>Persen</th>
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
    	if(actionId == 'create'){
    		
    	}
    ";

    $this->registerJs($scriptProjectFormPayment, \yii\web\View::POS_END);
?>