<div class="project-detail-wrapper">
	<nav>
		<div class="nav nav-tabs" id="nav-tab" role="tablist">
			<a class="nav-item nav-link active" id="nav-detail-data" data-toggle="tab" href="#detail-data" role="tab" aria-controls="detail-data" aria-selected="true">Detail Project</a>
			<a class="nav-item nav-link" id="nav-detail-item" data-toggle="tab" href="#detail-item" role="tab" aria-controls="detail-item" aria-selected="false">Item Project & Harga</a>
			<a class="nav-item nav-link" id="nav-detail-worker" data-toggle="tab" href="#detail-worker" role="tab" aria-controls="detail-worker" aria-selected="false">Pekerja</a>
		</div>
	</nav>
	<div class="tab-content" id="nav-tabContent">
		<div class="tab-pane fade show active" id="detail-data" role="tabpanel" aria-labelledby="detail-data-tab">
			<div class="card card-light mb-3" id="project-info-container">
			    <div class="card-header bg-info text-white p-2">
			        <h4 class="card-title m-0">Detail Project dan Data Lainnya</h4>
			    </div>
			    <div class="card-body p-2">
			    	<div class="form-row my-2">
						<div class="col-md-6">
							<label class="font-weight-bold">Start Project</label>
							<input class='form-control datepicker project_detail_input-StartDate' name="Project[Detail][StartDate]">
						</div>
						<div class="col-md-6">
							<label class="font-weight-bold">End Project</label>
							<input class='form-control datepicker project_detail_input-EndDate' name="Project[Detail][EndDate]">
						</div>
					</div>

			    	<div class="form-row my-2">
						<div class="col-md-6">
							<label class="font-weight-bold">Tipe Project</label>
							<select class="form-control project_detail_input-IdProjectType" name="Project[Detail][IdProjectType]">
								<option value="">- Tipe Project -</option>
								<?php foreach($projectType as $pt): ?>
									<option value="<?= $pt->Id ?>"><?= $pt->Type ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<!-- <div class="form-row my-2">
						<div class="col-md-12">
							<div class="border border-info p-3" style="border-width: 2px !important;height: 250px;">
								<i>JSON DATA INPUT UNTUK MASING-MASING DATA YANG HARUS DIISI BERDASARKAN TIPE PROJECT</i>
							</div>
						</div>
					</div> -->

			    	<div class="form-row my-2">
						<div class="col-md-12">
							<label class="font-weight-bold">Detail</label>
							<textarea class="form-control" name="Project[Detail][DetailDescription]" rows="5"></textarea>
						</div>
					</div>

					<div class="form-row my-2">
						<label class="font-weight-bold">Upload File</label>
						<div class="col-md-12">
							<div class="row mx-auto border border-info p-3 d-flex" id="upload-file-container">
								<span class="div-placeholder row justify-content-center align-self-center font-italic text-secondary w-100">
									Upload atau Paste di sini
								</span>
							</div>
							<button type="button" class="btn btn-sm btn-warning position-relative text-white">
				            Upload File
				                <input type="file" id="btn-uplodad-file" name="" multiple="true" style="position: absolute;top: 0;right: 0;margin: 0;opacity: 0;-ms-filter: 'alpha(opacity=0)';font-size: 200px;direction: ltr;cursor: pointer;width: 100px;height: 30px;">
				            </button>
						</div>
					</div>
			    </div>
			</div>
		</div>
		<div class="tab-pane fade" id="detail-item" role="tabpanel" aria-labelledby="detail-item-tab">
			<div class="card card-light mb-3" id="project-amount-container">
			    <div class="card-header bg-info text-white p-2">
			        <h4 class="card-title m-0">Item Project</h4>
			    </div>
			    <div class="card-body p-2">
			        <div class="row">
			            <div class="col-md-8">
			                <label class="font-weight-bold">Tambah Product</label>
			                <select class="form-control col-md-12 select2-product-input" style="width: 100% !important"></select>
			            </div>
			        </div>
			        <hr>

			        <div id="form-project-product">
			            <ul class="nav nav-tabs" role="tablist">
			                <li class='nav-item' id="nav-tab-summary">
			                    <a class='nav-link active' data-toggle='tab' href='#tab-content-summary'>
			                        Rangkuman
			                    </a>
			                </li>
			            </ul>
			            <div class="tab-content">
			                <div id="tab-content-summary" class='tab-pane active'>
			                    <table class="table table-striped table-summary table-sm">
			                        <thead>
			                            <tr>
			                                <th>#</th>
			                                <th>Product</th>
			                                <th>Modal</th>
			                                <th>Harga</th>
			                                <th>Margin</th>
			                            </tr>
			                        </thead>
			                        <tbody>
			                            <tr id="empty-summary">
			                                <th colspan=5 class="text-center">Produk masih kosong</th>
			                            </tr>
			                        </tbody>
			                        <tfoot class='bg-success text-white d-none'>
			                            <tr>
			                                <th colspan=2 class="text-center">Total</th>
			                                <th class='product-total-cost'></th>
			                                <th class='product-total-price'></th>
			                                <th class='product-total-margin'></th>
			                            </tr>
			                        </tfoot>
			                    </table>
			                </div>
			            </div>
			        </div>
			    </div>
			</div>
		</div>
		<div class="tab-pane fade" id="detail-worker" role="tabpanel" aria-labelledby="detail-worker-tab">
			<div class="card card-light mb-3" id="project-worker-container">
			    <div class="card-header bg-info text-white p-2">
			        <h4 class="card-title m-0">Pekerja</h4>
			    </div>
			    <div class="card-body p-2">
			    	<div class="row">
			    		<div class="col-md-6">
							<label class="font-weight-bold">List Pekerja</label>
							<input type="text" class="form-control" id="search-worker" placeholder="Nama Pekerja. . .">
						</div>
			    	</div>
			        <table class="table table-borderless" id="form-worker-list">
			    		<thead>
			    			<tr>
			    				<th>#</th>
			    				<th>Nama</th>
			    				<th>Role</th>
			                    <th>Start</th>
			    				<td></td>
			    			</tr>
			    		</thead>	
			    		<tbody id="worker-list"></tbody>
			    	</table>
			    </div>
			</div>
		</div>
	</div>
</div>