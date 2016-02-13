<?php
/**
 * @copyright Copyright (c) 2016 Vladyslav Holovko (vlad.holovko@gmail.com)
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace limion\jqueryfileupload;

use yii\web\AssetBundle;

class JavascriptTemplatesAsset extends AssetBundle
{
    public $sourcePath = '@bower/blueimp-tmpl';
    public $js = [
        // <!-- The Templates plugin is included to render the upload/download listings -->
        "js/tmpl.min.js",
    ];
}
