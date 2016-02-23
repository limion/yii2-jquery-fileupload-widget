#Blueimp file upload widget for Yii2

Yii2 port of [BlueImp jQuery File Upload plugin](http://blueimp.github.io/jQuery-File-Upload/). File Upload widget with multiple file selection, drag&drop support, progress bars, validation and preview images, audio and video for jQuery.
Supports cross-domain, chunked and resumable file uploads and client-side image resizing.  

One widget, simple configuration, everything works out of the box.

Inspired by https://github.com/2amigos/yii2-file-upload-widget

### Installation

From command line

```bash
$ composer require limion/yii2-jquery-fileupload-widget:~1.0
```

or add to your composer.json

```
"require": {
	"limion/yii2-jquery-fileupload-widget": "~1.0"
}	
```

### Usage

#### UI version
See: https://blueimp.github.io/jQuery-File-Upload/index.html  
Please note, in case of using a "UI" version you need to embed the widget to an existing form.
```PHP
<?php
use limion\jqueryfileupload\JQueryFileUpload;

<?php $form = ActiveForm::begin(); ?>
<?= JQueryFileUpload::widget([
        'model' => $model,
        'attribute' => 'img',
	'url' => ['upload', 'someparam' => 'somevalue'], // your route for saving images,
        'appearance'=>'ui', // available values: 'ui','plus' or 'basic'
        'gallery'=>true, // whether to use the Bluimp Gallery on the images or not
        'formId'=>$form->id,
        'options' => [
            'accept' => 'image/*'
        ],
        'clientOptions' => [
            'maxFileSize' => 2000000,
            'dataType' => 'json',
            'acceptFileTypes'=>new yii\web\JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
            'autoUpload'=>false
        ]
    ]);?>
<?php ActiveForm::end(); ?>    
```
##### Customizing the UI
You can use your own templates to customize the look and feel of upload,download and main views  

```PHP
<?php
use limion\jqueryfileupload\JQueryFileUpload;

<?php $form = ActiveForm::begin(); ?>
<?= JQueryFileUpload::widget([
        'model' => $model,
        'attribute' => 'img',
	'url' => ['upload', 'someparam' => 'somevalue'], // your route for saving images,
        'appearance'=>'ui', // available values: 'ui','plus' or 'basic'
        'uploadTemplateView'=>'@app/views/jqueryfileupload/upload', // upload template
        'downloadTemplateView'=>'@app/views/jqueryfileupload/download', // download template
        'mainView'=>'@app/views/jqueryfileupload/main', // main view with buttonbar
        'formId'=>$form->id,
        'clientOptions' => [
            'maxFileSize' => 2000000,
            'autoUpload'=>false
        ]
    ]);?>
<?php ActiveForm::end(); ?>    
```

#### Plus version
See: https://blueimp.github.io/jQuery-File-Upload/basic-plus.html

```PHP
<?php
use limion\jqueryfileupload\JQueryFileUpload;

$js = <<< 'JS'
var uploadButton = $('<button/>')
    .addClass('btn btn-primary')
    .prop('disabled', true)
    .text('Processing...')
    .on('click', function (e) {
        e.preventDefault();
        var $this = $(this),
            data = $this.data();
        $this
            .off('click')
            .text('Abort')
            .on('click', function () {
                $this.remove();
                data.abort();
            });
        data.submit().always(function () {
            $this.remove();
        });
    }); 
JS;

$this->registerJs($js);

?>

<?= JQueryFileUpload::widget([
	'name' => 'files[]',
	'url' => ['upload', 'someparam' => 'somevalue'], // your route for saving images,
	'appearance'=>'plus', // available values: 'ui','plus' or 'basic'
	'options' => ['accept' => 'image/*'],
	'clientOptions' => [
		'maxFileSize' => 2000000,
		'acceptFileTypes'=>new yii\web\JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
    'autoUpload'=>false
	],
	'clientEvents' => [
    'add' => "function (e, data) {
        data.context = $('<div/>').appendTo('#files');
        $.each(data.files, function (index, file) {
            var node = $('<p/>')
                    .append($('<span/>').text(file.name));
            if (!index) {
                node
                    .append('<br>')
                    .append(uploadButton.clone(true).data(data));
            }
            node.appendTo(data.context);
        });
    }",
    'processalways' => "function (e, data) {
        var index = data.index,
            file = data.files[index],
            node = $(data.context.children()[index]);
        if (file.preview) {
            node
                .prepend('<br>')
                .prepend(file.preview);
        }
        if (file.error) {
            node
                .append('<br>')
                .append($('<span class=\"text-danger\"/>').text(file.error));
        }
        if (index + 1 === data.files.length) {
            data.context.find('button')
                .text('Upload')
                .prop('disabled', !!data.files.error);
        }
    }",
    'progressall' => "function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress .progress-bar').css(
            'width',
            progress + '%'
        );
    }",
    'done' => "function (e, data) {
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                var link = $('<a>')
                    .attr('target', '_blank')
                    .attr('data-gallery','')
                    .prop('href', file.url);
                $(data.context.children()[index])
                    .wrap(link);
            } else if (file.error) {
                var error = $('<span class=\"text-danger\"/>').text(file.error);
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            }
        });
    }",
    'fail' => "function (e, data) {
        $.each(data.files, function (index) {
            var error = $('<span class=\"text-danger\"/>').text('File upload failed.');
            $(data.context.children()[index])
                .append('<br>')
                .append(error);
        });
    }"
  ],
]);?>
```

#### Basic version
See: https://blueimp.github.io/jQuery-File-Upload/basic.html

```PHP
<?php
use limion\jqueryfileupload\JQueryFileUpload;

<?= limion\jqueryfileupload\JQueryFileUpload::widget([
        'url' => ['upload', 'someparam' => 'somevalue'], // your route for saving images,
        'appearance'=>'basic', // available values: 'ui','plus' or 'basic'
        'name' => 'files[]',
        'options' => [
            'accept' => 'image/*'
        ],
        'clientOptions' => [
            'maxFileSize' => 2000000,
            'dataType' => 'json',
            'acceptFileTypes'=>new yii\web\JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
            'autoUpload'=>true
        ],
        'clientEvents' => [
            'done'=> "function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $('<p/>').text(file.name).appendTo('#files');
                });
            }",
            'progressall'=> "function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }"
        ]
    ]);?>
```    

