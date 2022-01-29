<?php 
    $this->registerCssFile("@web/web/css/jquery-ui.css", [
        'depends'=> [
            \yii\bootstrap4\BootstrapAsset::className()
        ]
    ]);

    $this->registerJsFile("@web/web/js/jquery-ui.js", [
        'depends'=> [
            \yii\bootstrap4\BootstrapAsset::className()
        ]
    ]);
    
?>
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
    		<tbody id="worker-list">
    			
    		</tbody>
           <!--  <tbody>
                <tr>
                    <td>
                        <button id="btn-add-worker" class="btn btn-warning">
                            <i class="fas fa-plus text-white"></i>
                        </button>
                    </td>
                </tr>
            </tbody> -->
    	</table>
    </div>
</div>
<?php 
    $projectWorkerScript = "
        var workerRole = ['Pekerja', 'Sales', 'Koordinator']

        $(document).ready(function(){
            var src = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: '".Yii::$app->urlManager->createUrl('project/get-worker')."&q=%QUERY',
                    wildcard: '%QUERY'
                }
            })

            $('#search-worker').typeahead(null, {
                name: 'name',
                display: 'Name',
                source: src
            })
        })

        $('body').on('typeahead:select', '#search-worker', function(ev, suggestion) {
            $(this).typeahead('val', '')
            if($('.worker_input-IdWorker[value='+suggestion.Id+']').length == 0){
                var lastNumber = (typeof $('#worker-list tr td:nth-child(1)').last().html() !== 'undefined'? parseInt($('#worker-list tr td:nth-child(1)').last().html()) : 0)

                createWorkerRow(lastNumber, suggestion.Id, suggestion.Name)
            }else{
                alert('pekerja sudah dipilih sebelumnya')
            }   
        })

        $('body').on('click', '.worker_remove', function(){
            $(this).parents('tr').remove()

            $(`tr[id^='worker_row-']`).each(function(x){
                $(this).find('td:nth-child(1)').html(parseInt(x)+1)

                $(this).find(`:input[name^='ProjectWorker']`).each(function(){
                    var name = $(this).attr('name').split(/[[\]]{1,2}/)
                    
                    $(this).attr('name', 'ProjectWorker['+x+']['+name[2]+']')
                })
            })
        })

        // $('#btn-add-worker').click(function(){
        //     var lastNumber = (typeof $('#worker-list tr td:nth-child(1)').last().html() !== 'undefined'? parseInt($('#worker-list tr td:nth-child(1)').last().html()) : 0)

        //     createWorkerRow(lastNumber)
        // })

        function createWorkerRow(lastNumber, idWorker = '', name = '', role = '', startAt = ''){
            var optionRole = ''

            $(workerRole).each(function(idx, val){
                optionRole += `<option value='`+val+`' `+(role == val? 'selected' : '')+`>`+val+`</option>`
            })

            var workerContent = $(`<tr id='worker_row-`+lastNumber+`'>
                                    <td>`+parseInt(lastNumber+1)+`</td>
                                    <td>
                                        <span class='worker_input-Name'>`+name+`</span>
                                        <input type='hidden' class='form-control worker_input-IdWorker' name='ProjectWorker[`+lastNumber+`][IdWorker]' value='`+idWorker+`'>
                                    </td>
                                    <td>
                                        <select class='form-control worker_input-Role' name='ProjectWorker[`+lastNumber+`][Role]'>
                                            <option value=''>- Role -</option>
                                            `+optionRole+`
                                        </select> 
                                    </td>
                                    <td>
                                        <input class='form-control worker_input-StartAt datepicker' name='ProjectItem[`+lastNumber+`][StartAt]' placeholder='Mulai bekerja. . .' value=`+startAt+`>
                                    </td>
                                    <td>
                                        <button type='button' class='btn btn-danger worker_remove'>
                                            <i class='fas fa-times'></i>
                                        </button>
                                    </td>
                                </tr>`)

            $('#form-worker-list #worker-list').append(workerContent)
            $(workerContent).find('.datepicker').datepicker({
                // minDate: 0,
                dateFormat: 'dd-mm-yy'
            })
        }

        function itemTypeaheadInit(inputTypeahead){
            var src = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: '".Yii::$app->urlManager->createUrl('project/get-sales-item')."&q=%QUERY',
                    wildcard: '%QUERY'
                }
            })

            inputTypeahead.typeahead(null, {
                name: 'name',
                display: 'Name',
                source: src
            })
        }
    ";

    $this->registerJs($projectWorkerScript, \yii\web\View::POS_END);
?>