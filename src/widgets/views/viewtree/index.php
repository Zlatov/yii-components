<?php
use yii\helpers\Html;
use yii\bootstrap\Alert;
use Zlatov\yiiComponents\assets\ViewTreeAsset;

$viewTreeAsset = ViewTreeAsset::register($this);
if (is_array($options['assetDepends'])) {
    $viewTreeAsset->depends = array_merge($viewTreeAsset->depends,$options['assetDepends']);
}

if ( $model && $model->errors && count($model->errors) ) {
    $errors = '';
    foreach ($model->errors as $key => $arrayOfErrors) {
        $errors.= implode('</p><p>', $arrayOfErrors);
    }
    $errors = '<p>' . $errors . '</p>';
    echo Alert::widget([
        'options' => [
            'class' => 'alert-danger',
        ],
        'body' => $errors,
    ]);
}

echo '<ul class="viewTree';
echo $options['drop']?' viewTreeDrop':'';
echo $options['toggleSlide']?' viewTreeToggleSlide':'';
echo '">' . PHP_EOL;

$level = 0;
$parentArray[$level] = $viewTree;
while ($level >= 0) {
    $mode = each($parentArray[$level]);
    if ($mode !== false) {

        $echo = [];
        foreach ($options['echo'] as $value) {
            if (is_array($value)) {
                $href = [];
                $href[] = $value['path'];
                foreach ($value['path_params'] as $paramkey => $paramvalue) {
                    $href[$paramkey] = $mode[1][$paramvalue];
                }
                $echo[] = Html::a($mode[1][$value['text']], $href, $value['attr']);
            } else {
                $echo[] = Html::encode($mode[1][$value]);
            }
        }
        if ($options['admin']) {
            $echo[0] = Html::a(
                $echo[0],
                [
                    Yii::$app->controller->id . '/' . $options['actionView'],
                    'id' => $mode[1][$options['modelId']],
                ],
                [
                    // 'class' => 'btn btn-default btn-xs',
                ]
            );
            $echo['update'] = Html::a(
                '<span class="glyphicon glyphicon-pencil"></span>',
                [
                    Yii::$app->controller->id . '/' . $options['actionUpdate'],
                    'id' => $mode[1][$options['modelId']],
                ],
                ['class' => 'btn btn-default btn-xs']
            );
            $echo['delete'] = Html::a(
                '<span class="glyphicon glyphicon-trash"></span>',
                [
                    Yii::$app->controller->id . '/' . $options['actionDelete'],
                    'id' => $mode[1][$options['modelId']],
                ],
                ['class' => 'btn btn-default btn-xs']
            );
        }
        echo $this->render('li', [
            'tab' => str_repeat("    ", $level*2 + 1),
            'echo' => $echo,
        ]);
        // echo "<pre>";
        // print_r(Yii::$app->controller->id);
        // echo "</pre>";
        // echo "<pre>";
        // print_r(Yii::$app->controller->action->id);
        // echo "</pre>";
        // die();
        // echo "<pre>";
        // print_r($options);
        // echo "</pre>";
        // die();

        if (count($mode[1][$options['childrens']])) {
            $level++;
            $parentArray[$level] = $mode[1][$options['childrens']];
            echo str_repeat("    ", $level*2) . "<ul>".PHP_EOL;
        } else {
            echo str_repeat("    ", $level*2 + 1) . "</li>".PHP_EOL;
        }
    } else {
        echo ($level>0)?str_repeat("    ", ($level)*2) . "</ul>".PHP_EOL:"</ul>".PHP_EOL;
        echo ($level>0)?str_repeat("    ", ($level)*2 - 1) . "</li>".PHP_EOL:'';
        $level--;
    }
}

?>