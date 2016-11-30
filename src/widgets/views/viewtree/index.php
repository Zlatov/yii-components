<?php

use Zlatov\yiiComponents\assets\ViewTreeAsset;
ViewTreeAsset::register($this);

echo '<ul class="viewTree';
echo $options['drop']?' viewTreeDrop':'';
echo '">' . PHP_EOL;

$level = 0;
$parentArray[$level] = $viewTree;
while ($level >= 0) {
    $mode = each($parentArray[$level]);
    if ($mode !== false) {

        $echo = [];
        foreach ($options['echo'] as $value) {
            $echo[] = $mode[1][$value];
        }
        echo $this->render('li', [
            'tab' => str_repeat("    ", $level*2 + 1),
            'echo' => $echo,
        ]);

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