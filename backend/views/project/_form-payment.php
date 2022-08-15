<div class="card card-light mb-3" id="project-payment-container">
    <div class="card-header bg-info text-white p-2">
        <h4 class="card-title m-0">Pembayaran</h4>
    </div>
	<div class="card-body p-2">
		<div class="form-row">
			<div class="col-md-4">
				<label class="font-weight-bold">Tipe Pembayaran</label>
				<select class="form-control payment_input-Installment" id="paymentInstallment" name="Project[Payment]['Installment']">
					<option value="">- Tipe Pembayaran -</option>
					<option value="50-50">50-50</option>
					<option value="50-30-20">50-30-20</option>
					<option value="Custom">Custom</option>
				</select>
			</div>
			<!-- <div class="col-md-4">
				<label class="payment_label-Destination font-weight-bold">Bank Tujuan</label>
                <select class="form-control payment_input-IdPaymentDestination" id="paymentDestination" name="Project[Payment]['IdPaymentDestination']">
					<option value="">- Bank -</option>
					<option value="1">BCA (937310098/Lucky 1)</option>
					<option value="2">BCA (479201233/Lucky 2)</option>
					<option value="3">BRI (028493635/Lucky 3)</option>
				</select>
			</div> -->
			<div class="col-md-4 offset-md-4">
				<label class="font-weight-bold">Total</label><br>
				<input type="hidden" class='form-control payment_input-PaymentAmount' id="paymentAmount" value='250000000'>
				<h3>
                    <span class="payment_label-PaymentAmount">
                        Rp <?= number_format('250000000', 0, '', '.') ?>
                    </span>
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
					<th class="text-center">Fase</th>
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
</div>