<?php
    use yii\helpers\Html;

    $this->title = 'Create Project';
?>
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
<script>
    var actionId = 'create'
    var dataProject = {}
    var arrProjectFiles = {
        'Img' : [],
        'Doc' : [],
    }

    const validDocTypes = <?= json_encode(Yii::$app->params['validDocTypes']) ?>;
    const validImageTypes = <?= json_encode(Yii::$app->params['validImageTypes']) ?>;
    const docIcon = <?= json_encode(Yii::$app->params['docIcon']) ?>;
</script>