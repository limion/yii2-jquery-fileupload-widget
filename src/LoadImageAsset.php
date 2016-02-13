<?php
/**
 * @copyright Copyright (c) 2016 Vladyslav Holovko (vlad.holovko@gmail.com)
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace limion\jqueryfileupload;

use yii\web\AssetBundle;

class LoadImageAsset extends AssetBundle
{
    public $sourcePath = '@bower/blueimp-load-image';
    public $js = [
        // <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
        "js/load-image.all.min.js",
    ];
}
