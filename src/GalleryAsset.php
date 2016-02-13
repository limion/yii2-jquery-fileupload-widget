<?php
/**
 * @copyright Copyright (c) 2016 Vladyslav Holovko (vlad.holovko@gmail.com)
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace limion\jqueryfileupload;

use yii\web\AssetBundle;


class GalleryAsset extends AssetBundle
{
    public $sourcePath = '@bower/blueimp-gallery';
    public $css = [
        'css/blueimp-gallery.min.css',
    ];
    public $js = [
        // <!-- blueimp Gallery script -->
        "js/jquery.blueimp-gallery.min.js",
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
