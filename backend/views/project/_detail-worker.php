<div class="card card-light mb-3" id="project-worker-container">
    <div class="card-header bg-info text-white p-2">
        <h4 class="card-title m-0">Pekerja</h4>
    </div>
    <div class="card-body p-2">
    	<div class="row">
    		<div class="col-md-6">
				<label class="font-weight-bold">List Pekerja</label>
				<input type="text" class="form-control" id="projectworker_input-Worker" placeholder="Nama Pekerja. . .">
			</div>
    	</div>
        <table class="table table-borderless" id="form-sales-item">
    		<thead>
    			<tr>
    				<th>#</th>
    				<th>Nama</th>
    				<th>Role</th>
    				<td></td>
    			</tr>
    		</thead>	
    		<tbody id="worker-list">
    			
    		</tbody>
            <tbody>
                <tr>
                    <td>
                        <button id="btn-add-worker" class="btn btn-warning">
                            <i class="fas fa-plus text-white"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
    	</table>
    </div>
</div>
<?php 
    $projectWorkerScript = "
        var workerRole = ['Pekerja', 'Sales', 'Koordinator']

        $(document).ready(function(){
            console.log('asd')
            console.log(workerRole)
        })

        $('#btn-add-worker').click(function(){
            var lastNumber = (typeof $('#worker-list tr td:nth-child(1)').last().html() !== 'undefined'? parseInt($('#worker-list tr td:nth-child(1)').last().html()) : 0)

            createWorkerRow(lastNumber)
        })

        function createWorkerRow(lastNumber, name = '', role = ''){
            var itemContent = $(`<tr id='item_row-`+lastNumber+`'>
                                    <td>`+parseInt(lastNumber+1)+`</td>
                                    <td>
                                        <input class='form-control item_input-ItemName' name='ProjectItem[`+lastNumber+`][ItemName]' placeholder='Item. . .' value='`+itemName+`' data-text='`+itemName+`'>
                                        <input class='form-control item_input-IdItem' placeholder='this supposed to be hidden' name='ProjectItem[`+lastNumber+`][IdItem]' value=`+idItem+`>
                                    </td>
                                    <td>
                                        <div class='input-group mb-3'>
                                            <input class='form-control item_input-Qty' name='ProjectItem[`+lastNumber+`][Qty]' placeholder='Qty. . .' value=`+qty+`>
                                            <div class='input-group-append'>
                                                <span class='input-group-text item_input-ItemUoM'>-</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <input class='form-control item_input-Price' name='ProjectItem[`+lastNumber+`][Price]' placeholder='Price. . .' value=`+price+`>
                                    </td>
                                    <td>
                                        <button type='button' class='btn btn-danger item_remove'>
                                            <i class='fas fa-times'></i>
                                        </button>
                                    </td>
                                </tr>`)

            $('#form-sales-item #item-list').append(itemContent)

            itemTypeaheadInit($('#item_row-'+lastNumber+' .item_input-ItemName'))
        }
    ";
?>