<div class="card card-light mb-3" id="project-client-container">
    <div class="card-header bg-info text-white p-2">
        <h4 class="card-title m-0">Data Perusahaan/Client</h4>
    </div>
	<div class="card-body p-2">
		<div class="form-row">
			<div class="form-group col-md-6">
	            <label class="font-weight-bold" for="item_input-ItemName">Perusahaan/Nama Client</label>
	            <input type="text" class="form-control" id="projectclient_input-Company" placeholder="Perusahaan/Nama Client. . ." name="Project[Client][Company]">
	        </div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-12">
				<label class="font-weight-bold" for="item_input-ItemName">Alamat</label>
	            <textarea type="text" class="form-control" id="projectclient_input-Address" placeholder="Alamat. . ." name="Project[Client][Address]" rows=5></textarea>
			</div>
		</div>
	</div>
</div>

<div class="card card-light mb-3" id="project-contact-container">
    <div class="card-header bg-info text-white p-2">
        <h4 class="card-title m-0">Kontak</h4>
    </div>
    <div class="card-body p-2">
    	<div class="form-row form-label">
    		<div class="col-md-1 text-center"><label class="font-weight-bold">#</label></div>
    		<div class="col-md-2"><label class="font-weight-bold">Nama</label></div>
            <div class="col-md-2"><label class="font-weight-bold">Jabatan</label></div>
    		<!-- <div class="col-md-2"><label class="font-weight-bold">Role</label></div> -->
    		<div class="col-md-2"><label class="font-weight-bold">Phone</label></div>
    		<div class="col-md-2"><label class="font-weight-bold">Email</label></div>
    	</div>
    	<div id="project-contact-list">

        </div>
        <div class="form-row mt-4">
        	<div class="col-md-6">
        		<button class="btn btn-warning" id="btn-add-contact"><i class="fas fa-plus text-white"></i></button>
        	</div>
            <!-- <div class="col-md-6 text-right">
                <button type="button" class="btn btn-success" id="save_ItemCombined">Save</button>
            </div> -->
        </div>
    </div>
</div>
