<?php
namespace Zlatov\yiiComponents\widgets;

use yii\base\Widget;

class ViewTree extends Widget
{
    public $viewTree;
    public $options;
    public $model;

    private static $defOptions = [
        'childrens'    => 'childrens', // Тут хранятся дети
        'echo'         => ['header'],  // Массив полей для вывода в интерфейс
        'drop'         => true,        // Вывод дерева с плюсиками или нет
        'toggleSlide'  => true,        // Вывод кнопки разворачивания/сворачивания всего дерева
        'admin'        => false,       // Выводить ли кнопки администрирования
        'actionUpdate' => 'update',
        'actionDelete' => 'delete',
        'actionView'   => 'view',
        'modelId'      => 'id',
        'assetDepends' => null,
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
            'model' => $this->model,
        ]);
    }
}