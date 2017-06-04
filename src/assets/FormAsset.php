<?php
namespace Zlatov\yiiComponents\assets;

use yii\web\AssetBundle;

class FormAsset extends AssetBundle
{
    public $sourcePath = '@vendor/zlatov/yii-components/src/assets/sources/';
    public $css = [
        'form.css',
    ];
    public $js = [
    ];
    public $depends = [
    ];
}
