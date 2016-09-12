<?php
use yii\helpers\Html;

$context = $this->context;
?>
<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
<div class="row fileupload-buttonbar">
    <div class="col-lg-7">
        <!-- The fileinput-button span is used to style the file input field as button -->
        <span class="btn btn-success fileinput-button">
            <i class="glyphicon glyphicon-plus"></i>
            <span><?= Yii::t('jqueryfileupload', 'Add files') ?>...</span>

            <?php
                $name = $context->model instanceof \yii\base\Model && $context->attribute !== null ? Html::getInputName($context->model, $context->attribute) : $context->name;
                $value = $context->model instanceof \yii\base\Model && $context->attribute !== null ? Html::getAttributeValue($context->model, $context->attribute) : $context->value;
                echo Html::hiddenInput($name, $value).Html::fileInput($name, $value, $context->options);
            ?>

        </span>
    </div>
    <!-- The global progress state -->
    <div class="col-lg-5 fileupload-progress">
        <!-- The global progress bar -->
        <div id="progress" class="progress">
            <div class="progress-bar progress-bar-success"></div>
        </div>
    </div>
</div>
<!-- The container for the uploaded files -->
<div id="files" class="files"></div>
        