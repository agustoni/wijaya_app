<?php 
	$this->title = "Create";
	$this->params['breadcrumbs'][] = ['label' => 'Purchase Order', 'url' => ['index']];
	$this->params['breadcrumbs'][] = $this->title;
	\yii\web\YiiAsset::register($this);
?>

<div class="card card-light mb-3" id="po-create-container">
	<div class="card-header bg-info text-white p-2">
        <h4 class="card-title m-0">Create PO</h4>
    </div>
    <?php if(isset($_GET['id'])): ?>
	    <h4>PO Project <?= $_GET['id'] ?></h4>
	<?php endif; ?>
    <div class="card-body p-2">
		<table class="table table-hover table-sm" id='project-item-list'>
			<thead>
				<tr>
					<th class="text-center" style="width:5%">#</th>
					<th class="" style="width:5%">
						<input style='width:20px;height:20px' class='projectitem-selectall' type='checkbox'>
					</th>
					<th style="width:30%">Item</th>
					<th style="width:30%">Supplier</th>
					<th style="width:10%">Qty</th>
					<th style="width:15%">Harga</th>
					<td style="width:5%"></td>
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
		<div class="row">
			<div class="col-md-12">
				<button class='btn btn-warning btn-sm' id="add-project-item">
                    <i class='fas fa-plus text-white'></i>
                </button>
			</div>
		</div>
    </div>
</div>
<script>
	// $scriptCreatePO = "
		var idProject = '<?= (isset($_GET['id'])? $_GET['id'] : null) ?>'
		$(document).ready(function(){
			if(idProject){
				console.log('idProject')
			}else{
				createPOItem(0)
			}
		})

		$('#add-project-item').click(function(){
			var lastNumber = (typeof $('#project-item-list').find('tbody tr td:nth-child(1)').last().html() !== 'undefined'? 
                                            parseInt($('#project-item-list').find('tbody tr td:nth-child(1)').last().html()) 
                                            : 0)
            $('#project-item-list').find('table tbody').append(createPOItem(lastNumber))
		})

		$('body').on('typeahead:select', '.projectitem_input-ItemName', function(ev, suggestion) {
            console.log(suggestion)

            // $('#itempart_input-ItemParentId').val(suggestion.Id)
            // $('#itempart_input-ItemParentId').attr('data-text', suggestion.Name)

            // $('#item-part-list').empty()
            $(this).parents('tr').find('.projectitem_input-IdItem').val(suggestion.IdSupplierItem)

            getSupplierItem($(this).parents('tr'), suggestion.IdItem)
        })

        $("body").on("keypress change", ".isNumber", function (evt){
	        evt = (evt) ? evt : window.event;
	        var charCode = (evt.which) ? evt.which : evt.keyCode;

	        if (charCode == 46 || (charCode < 48 || charCode > 57)) {
	            return false;
	        }

	        value = $(this).val().replace(/^(0*)/,"");
	        $(this).val(value);

	        return true;
	    })

	    $("body").on("keyup", ".calc", function(){
	    	var el = $(this).parents("tr")
	    	var price = $(el).find(".projectitem_input-IdSupplier :selected").attr('data-price')? $(el).find(".projectitem_input-IdSupplier :selected").attr('data-price') : 0
	    	var qty = $(el).find(".projectitem_input-Qty").val()? $(el).find(".projectitem_input-Qty").val() : 0
	    	var total = parseInt(price) * parseInt(qty)

	    	$(el).find(".projectitem_input-Price").val(total)
	    })

	    $("body").on("click", ".projectitem_remove", function(){
	    	var tr = $(this).parents("tr")
	    	var tbody = $(this).parents("tbody")

	    	if($("#project-item-list tbody tr").length > 1){
	    		tr.remove()
	    		$(tbody).find('tr').each(function(x){
	    			$(this).find('td:nth-child(1)').html(parseInt(x)+1)
	    			$(this).attr("id", "projectitem-row_"+x)
                })
	    	}else{
	    		$("#project-item-list tbody tr").find(":input").val("")
	    	}
	    })

        function getSupplierItem(el, IdItem){
        	$.ajax({
                type: 'POST',
                url: '<?= Yii::$app->urlManager->createUrl("purchase-order/get-supplier-item") ?>',
                data: {IdItem},
                dataType:'json',
                async: true,
                beforeSend: function() {
                    $('#po-create-container').busyLoad('show', {spinner: 'cube',text: 'loading'})
                },
                success: function(d){
                    if(d.length > 0){
                    	$(d).each(function(idx, val){
                    		console.log(val)
                    		var option = $(`<option value='`+val.IdSupplier+`' `+(idx == 0 ? 'selected' : '')+` data-price='`+val.Price+`'>`+val.SupplierName+`</option>`)
                    		$(el).find('.projectitem_input-IdSupplier').append(option)
                    	})

                    	supplierItemChange(el)
                    }else{
                    	alert('Supplier untuk item yang dipilih tidak ditemukan')
                    }
                },
            }).complete(function(d){
                $('#po-create-container').busyLoad('hide')
            })
        }

        function supplierItemChange(el){
        	var price = $(el).find(".projectitem_input-IdSupplier :selected").attr('data-price')

        	$(el).find(".projectitem_input-Qty").val(1)
        	$(el).find(".projectitem_input-Price").val(price)
        }

		function createPOItem(lastNumber, idProjectItem = '', idItem = '', itemName = '', idSupplier = '', supplierName = '', qty = '', harga = ''){
			var poItemContent = $(`<tr id='projectitem-row_`+lastNumber+`'>
										<td class='align-middle text-center'>`+(lastNumber + 1)+`</td>
										<td class='align-middle'>
											<input style='width:20px;height:20px' class='projectitem_input-IdProjectItem' type='checkbox' value='`+idProjectItem+`'>
										</td>
										<td class='align-middle'>
											<input class='form-control projectitem_input-ItemName' value='`+itemName+`'>
											<input class='form-control projectitem_input-IdItem' value='`+idItem+`'>
										</td>
										<td class='align-middle'>
											<!-- <input class='form-control projectitem_input-SupplierName' value='`+idSupplier+`'>
											<input class='form-control projectitem_input-IdSupplier' value='`+idSupplier+`'> -->
											<select class='form-control projectitem_input-IdSupplier'></select>
										</td>
										<td class='align-middle'>
											<input class='form-control projectitem_input-Qty isNumber calc' value='`+qty+`'>
										</td>
										<td class='align-middle'>
											<input class='form-control projectitem_input-Price isNumber' value='`+harga+`'>
										</td>
										<td class='align-middle text-center'>
											<button type='button' class='btn btn-danger projectitem_remove'>
                                                <i class='fas fa-times'></i>
                                            </button>
										</td>
								   </tr>`)

			$('#project-item-list tbody').append(poItemContent)
			itemTypeaheadInit($('#project-item-list tbody').find('#projectitem-row_'+lastNumber+' .projectitem_input-ItemName'))
			// supplierTypeaheadInit($('#project-item-list tbody').find('#projectitem-row_'+lastNumber+' .projectitem_input-SupplierName'))
		}

		function itemTypeaheadInit(inputTypeahead){
            var src = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: '<?= Yii::$app->urlManager->createUrl('purchase-order/get-sales-item')."&q=%QUERY" ?>',
                    wildcard: '%QUERY'
                }
            })

            inputTypeahead.typeahead(null, {
                name: 'name',
                display: 'Name',
                source: src
            })
        }

        // function supplierTypeaheadInit(inputTypeahead){
        //     var src = new Bloodhound({
        //         datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        //         queryTokenizer: Bloodhound.tokenizers.whitespace,
        //         remote: {
        //             url: '<?php //echo Yii::$app->urlManager->createUrl('project/get-supplier')."&q=%QUERY" ?>',
        //             wildcard: '%QUERY'
        //         }
        //     })

        //     inputTypeahead.typeahead(null, {
        //         name: 'name',
        //         display: 'Name',
        //         source: src
        //     })
        // }


	// ";

	// $this->registerJs($scriptCreatePO, \yii\web\View::POS_END);

</script>