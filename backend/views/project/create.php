<?php
    use yii\helpers\Html;
    // $this->registerCssFile("@web/web/css/select2.min.css", [
    //     'depends'=> [
    //         \yii\bootstrap4\BootstrapAsset::className()
    //     ]
    // ]);

    // $this->registerJsFile("@web/web/js/select2.min.js",[
    //     'depends' => [
    //         \yii\web\JqueryAsset::className()
    //     ],
    //     'position' => \yii\web\View::POS_END
    // ]);

    $this->title = 'Create Project';
?>
<style>
    /*.twitter-typeahead {width: 85%;}
    .textarea-item > .twitter-typeahead{width: 85%;}

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }*/
</style>
<div class="project-create">
    <div class="row mb-2">
        <div class="col-md-3">
            <h3><?= Html::encode($this->title) ?></h3>
        </div>
    </div>
    <div class="form-project-wrapper" id="smartwizard">
        <?= $this->render('_form-wrapper', [
                "projectType" => $projectType
        ]) ?>
    </div>
</div>
<?php
    $scriptProjectCreate="
        var actionId = 'create'
    ";

    $this->registerJs($scriptProjectCreate, \yii\web\View::POS_END);
?>