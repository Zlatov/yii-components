<?php
namespace Zlatov\yiiComponents\widgets;

use yii\base\Widget;

class ViewTree extends Widget
{
    public $viewTree;
    public $options;
    public function run()
    {
        return $this->render('views/viewtree/index',[
            'viewTree' => $this->viewTree,
            'options' => $this->options,
        ]);
    }
}