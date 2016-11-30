<?php
namespace Zlatov\yiiComponents\assets;

use yii\web\AssetBundle;

class ViewTreeAsset extends AssetBundle
{
    public $sourcePath = '@vendor/zlatov/yii-components/src/assets/sources/viewtree/';
    public $css = [
        'css/css.css',
    ];
    public $js = [
        'js/js.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
