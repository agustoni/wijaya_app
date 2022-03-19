<?php 
    use yii\helpers\Html;

    $this->registerCssFile("@web/web/css/smart_wizard.css", [
        'depends'=> [
            \yii\bootstrap4\BootstrapAsset::className()
        ]
    ]);

    $this->registerCssFile("@web/web/css/smart_wizard_arrows.css", [
        'depends'=> [
            \yii\bootstrap4\BootstrapAsset::className()
        ]
    ]);

    $this->registerJsFile("@web/web/js/jquery.smartWizard.js",[
        'depends' => [
            \yii\web\JqueryAsset::className()
        ],
        'position' => \yii\web\View::POS_END
    ]);
?>

<ul class="nav">
    <li>
        <a class="nav-link" href="#data-client">
            Client
        </a>
    </li>
    <li>
        <a class="nav-link" href="#data-detail">
            Detail
        </a>
    </li>
    <li>
        <a class="nav-link" href="#data-payment">
            Payment
        </a>
    </li>
</ul>
<div class="tab-content">
    <!-- DATA PROJECT CLIENT -->
        <div id="data-client" class="tab-pane" role="tabpanel">
            <?= $this->render('_form-client', [
                // "model" => $model
            ]) ?>
        </div>
    <!-- END DATA PROJECT CLIENT -->

    <!-- DATA PROJECT DETAIL -->
        <div id="data-detail" class="tab-pane" role="tabpanel">
            <?= $this->render('_form-detail', [
                "projectType" => $projectType
            ]) ?>
        </div>
    <!-- END DATA PROJECT DETAILT -->

    <!-- DATA PROJECT PAYMENT -->
        <div id="data-payment" class="tab-pane" role="tabpanel">
            <?= $this->render('_form-payment', [
                // "model" => $model
            ]) ?>
        </div>
    <!-- END DATA PROJECT PAYMENT -->
</div>
<?php
    $scriptProjectFormWrapper="
        $(window).on('load', function(){
            var dataProject = {}
            
            if(actionId == 'create'){
                dataProject.Client = {}
                dataProject.Detail = {}
                dataProject.Payment = {}
            }else if(actionId == 'view'){
                var dataProject = ".(isset($dataProject)? $dataProject : '')."

                // render data
                viewData(dataProject)
            }
        })

        function viewData(dataProject){
            // ========= _form-client =========
                $('#projectclient_input-Company').val(dataProject.Client.Company)
                $('#projectclient_input-Address').val(dataProject.Client.Address)

                //create contact row
                $.each(dataProject.Client.Contact, function(idx, val){
                    var contactLastNumber = (typeof $('#project-contact-list div:nth-child(1) label').last().html() !== 'undefined'? parseInt($('#project-contact-list div:nth-child(1) label').last().html()) : 0)

                    createContactRow(contactLastNumber, val.Id, val.Name, val.Title, val.Role, val.Phone, val.Email)
                })
            // ========= END _form-client =========

            // ========= _form-detail => _detail-data =========
                $('.project_detail_input-IdProjectType').val(dataProject.Detail.IdProjectType)
                CKEDITOR.instances['Project[Detail]'].setData(dataProject.Detail.DetailDescription)
            // ========= END _form-detail => _detail-data =========

            // ========= _form-detail => _detail-data->File =========
                // asdasdasdasds
                // asdasdasdasds
            // ========= END _form-detail => _detail-data->File =========

            // ========= _form-detail => _detail-item =========
                $.each(dataProject.DetailItem, function(idx, prd){
                    createProduct(prd, prd.total.Cost, prd.total.Margin, prd.total.Price)
                })
            // ========= END _form-detail => _detail-item =========

            // ========= _form-detail => _detail-worker =========
                $.each(dataProject.Worker, function(idx, worker){
                    var lastNumber = (typeof $('#worker-list tr td:nth-child(1)').last().html() !== 'undefined'? parseInt($('#worker-list tr td:nth-child(1)').last().html()) : 0)

                    createWorkerRow(lastNumber, worker.Id, worker.Name, worker.Role, worker.StartAt, worker.StatusDate)
                })
            // ========= END _form-detail => _detail-worker =========

            // ========= _form-payment =========

            // ========= END _form-payment =========
        }

        const validDocTypes = JSON.parse('".json_encode(Yii::$app->params['validDocTypes'])."')
        const validImageTypes = JSON.parse('".json_encode(Yii::$app->params['validImageTypes'])."')
        const docIcon = JSON.parse('".json_encode(Yii::$app->params['docIcon'])."')

        var arrProjectFiles = {
            'Img' : [],
            'Doc' : [],
        }

        $('#smartwizard').smartWizard({
            // selected: 1,
            theme: 'arrows',
            transition: {
                animation: 'fade'
            },
            justified: true,
            enableURLhash: true,
            autoAdjustHeight: false,
            keyboardSettings: {
                keyNavigation: false, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
            },
            anchorSettings: {
                enableAllAnchors: true, // Activates all anchors clickable all times
                markDoneStep: false, // Add done state on navigation
            },
            toolbarSettings:{
                toolbarExtraButtons: [
                    $('<button></button>')
                        .text('Finish')
                        .addClass('btn btn-success')
                        .attr('id', 'btn-submit-form')
                        .attr('style', 'display:none')
                        .attr('type', 'button')
                ]
            }
        })

        // Initialize the leaveStep event
        $('#smartwizard').on('leaveStep', function(e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {
            if(currentStepIndex == 0){
                console.log('client --> detail')
            }else if(currentStepIndex == 1){
                console.log('detail --> payment')
            }else{

            }
        })

        $('#smartwizard').on('showStep', function(e, anchorObject, stepIndex, stepDirection) {
            if(stepIndex == 2 && stepDirection == 'forward'){
                $('.sw-btn-next').hide()
                $('#btn-submit-form').show()
            }else{
                $('.sw-btn-next').show()
                $('#btn-submit-form').hide()
            }
        })
        
    ";

    $this->registerJs($scriptProjectFormWrapper, \yii\web\View::POS_END);
?>