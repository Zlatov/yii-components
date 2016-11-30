<?php
namespace Zlatov\yiiComponents\widgets;

use yii\base\Widget;

class ViewTree extends Widget
{
    public $viewTree;
    public $options;
    private static $defOptions = [
        'childrens' => 'childrens',
        'echo' => ['header'],
        'drop' => true,
    ];

    public function init()
    {
        parent::init();

        if ($this->options === null) {
            $this->options = self::$defOptions;
        } else {
            $this->options = array_merge(self::$defOptions, $this->options);
        }
    }

    public function run()
    {
        return $this->render('viewtree/index',[
            'viewTree' => $this->viewTree,
            'options' => $this->options,
        ]);
    }
}