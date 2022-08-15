<div class="card-body p-2">
	<table class="table table-hover table-sm" id='project-item-list'>
		<thead>
			<tr>
				<th class="text-center" style="width:5%">#</th>
				<!-- <th class="" style="width:5%">
					<input style='width:20px;height:20px' class='projectitem-selectall' type='checkbox'>
				</th> -->
				<th style="width:25%">Item</th>
				<th style="width:10%">UoM</th>
				<th style="width:20%">Supplier</th>
				<th style="width:10%">Qty</th>
				<th style="width:15%">Harga</th>
				<th style="width:15%">Total</th>
				<td style="width:5%"></td>
			</tr>
		</thead>
		<tbody></tbody>
		<tfoot>
			<tr class="bg-info">
				<th colspan=6 class="text-right">Total PO</th>
				<th colspan="1">
				    <span class="float-left">Rp </span>
				    <span class="float-right" id="po-total">0</span>
				</th>
			</tr>
		</tfoot>
	</table>
	
	<?php if(!$model->ApprovedAt): ?>
		<div class="row">
			<div class="col-md-6">
				<button class='btn btn-warning btn-sm' id="add-project-item">
	                <i class='fas fa-plus text-white'></i>
	            </button>
			</div>
			<div class="col-md-6 text-right">
				<button class="btn btn-success" id="submit-po">Submit</button>
			</div>
		</div>
	<?php endif; ?>
</div>
<script>
	var actionId = '<?= Yii::$app->controller->action->id ?>';
	var idPo = <?= (isset($_GET['id'])? $_GET['id'] : 'null') ?>;
	var arrPoItem = <?= (isset($arrPoItem)? $arrPoItem : 'null') ?>;
	var statusUpdate = <?= $model->ApprovedAt? 0 : 1 ?>;
	var _poTotal = <?= $model->Total? $model->Total : 'null' ?>;
</script>