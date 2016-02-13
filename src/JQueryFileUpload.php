<?php
/**
 * @copyright Copyright (c) 2016 Vladyslav Holovko (vlad.holovko@gmail.com)
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace limion\jqueryfileupload;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Url;
use yii\jui\InputWidget;
use yii\helpers\Json;
use yii\helpers\Html;


class JQueryFileUpload extends InputWidget
{
    /**
     * @var string|array upload route
     */
    public $url;
    
    /**
     * @var string the variant of the asset to load, can be one of the following: 'basic','plus' or 'ui', that corresponds Basic, Basic Plus or Basic Plus UI version 
     */
    public $appearance = 'ui'; 
    
    /**
     * @var string the id of the surrounded form tag. If $appearance='ui' form must be provided.
     */
    public $formId;
    
    /**
     * @var string the main view path to render the corresponding template with fileinput-button
     */
    public $mainView;
    
    /**
     * @var string the upload view path to render the js upload template
     */
    public $uploadTemplateView = 'upload';
    
    /**
     * @var string the download view path to render the js download template
     */
    public $downloadTemplateView = 'download';
    
    /**
     * @var bool whether to use the Bluimp Gallery on the images or not
     */
    public $gallery = true;
    
    /**
     * @var string the gallery view path to render the gallery template
     */
    public $galleryTemplateView = 'gallery';
    
    /**
     * @var array for the internalization configuration
     */
    public $i18n = [];
    
    /**
     * @inheritdoc
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->registerTranslations();
        
        if(empty($this->url)) {
            throw new InvalidConfigException('"url" cannot be empty.');
        }
        if(empty($this->formId) && 'ui' == $this->appearance) {
            throw new InvalidConfigException('"formId" cannot be empty in case of "appearance"=="ui".');
        }
        if(empty($this->mainView)) {
            $this->mainView = 'ui' == $this->appearance ? 'mainPlusUI' : 'main';
        }

        $this->clientOptions['url'] = $this->options['data-url'] = Url::to($this->url);
        if (!isset($this->options['multiple'])) {
            $this->options['multiple'] = true;
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        echo $this->render($this->mainView);
        if ($this->gallery) {
            echo $this->render($this->galleryTemplateView);
        }
        if('ui' == $this->appearance) {
            echo $this->render($this->uploadTemplateView);
            echo $this->render($this->downloadTemplateView);
        }
        
        $this->registerClientScript();
    }
    
    /**
     * Registers required script for the plugin to work as jQuery File Uploader
     */
    public function registerClientScript()
    {
        $view = $this->getView();
        
        if ($this->gallery) {
            GalleryAsset::register($view);
        }
        switch ($this->appearance) {
            case 'ui':
                JQueryFileUploadPlusUIAsset::register($view);
                break;    
            
            case 'plus':
                JQueryFileUploadPlusAsset::register($view);
                break;
            
            default:
                JQueryFileUploadAsset::register($view);
        }

        $id = $this->formId ? : $this->options['id'];
        $this->registerClientOptions('fileupload', $id);
        $this->registerClientEvents('fileupload', $id);
    } 
    
    /**
     * i18n
     */
    public function registerTranslations()
    {
        $i18n = Yii::$app->i18n;
        Yii::setAlias('@jqueryfileupload', dirname(__FILE__));
        if (empty($this->i18n)) {
            $this->i18n = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'basePath' => '@jqueryfileupload/messages'
            ];
        }
        Yii::$app->i18n->translations['jqueryfileupload'] = $this->i18n;
    }
}
