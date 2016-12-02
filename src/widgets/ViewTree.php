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
        'admin' => false,
        'actionUpdate' => 'update',
        'actionDelete' => 'delete',
        'actionView' => 'view',
        'modelId' => 'id',
    ];

    public function init()
    {
        parent::init();

        if ($this->options === null) {
            $this->options = self::$defOptions;
        } else {
            $this->options = array_merge(self::$defOptions, $this->options);
        }
        // echo "<pre>";
        // print_r($this->options);
        // echo "</pre>";
        // die();
    }

    public function run()
    {
        return $this->render('viewtree/index',[
            'viewTree' => $this->viewTree,
            'options' => $this->options,
        ]);
    }
}