<?php
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

$this->title = "Table Files";
$this->params['subtitle'] = "Upload table file";
$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->params['subtitle'];
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'file')->widget(FileInput::classname(), [
                'options' => ['accept' => 'html/*'],
               'pluginOptions'=>['allowedFileExtensions'=>['html'],'showUpload' => false,],
          ]);   ?>

<div class="pull-right">
    <button>Submit</button>
</div>

<?php ActiveForm::end() ?>