<?php
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'file')->widget(FileInput::classname(), [
              //'options' => ['accept' => 'image/*'],
               'pluginOptions'=>['allowedFileExtensions'=>['html'],'showUpload' => false,],
          ]);   ?>

    <button>Submit</button>

<?php ActiveForm::end() ?>