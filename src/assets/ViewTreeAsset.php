<?php
namespace Zlatov\yiiComponents\assets;

use yii\web\AssetBundle;

class ViewTreeAsset extends AssetBundle
{
    public $sourcePath = '@vendor/zlatov/yii-components/src/assets/sources/viewtree/';
    public $css = [
        'css/viewtree.css',
    ];
    public $js = [
        'js/viewtree.js',
    ];
    public $depends = [
    ];
}
