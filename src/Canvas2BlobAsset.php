<?php
/**
 * @copyright Copyright (c) 2016 Vladyslav Holovko (vlad.holovko@gmail.com)
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace limion\jqueryfileupload;

use yii\web\AssetBundle;

class Canvas2BlobAsset extends AssetBundle
{
    public $sourcePath = '@bower/blueimp-canvas-to-blob';
    public $js = [
        // <!-- The Canvas to Blob plugin is included for image resizing functionality -->
        "js/canvas-to-blob.min.js",
    ];
}
