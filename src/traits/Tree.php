<?php
namespace Zlatov\yiiComponents\traits;

trait Tree
{
    private static $treeDefOptions = [
        'fnId' => 'id',
        'fnPid' => 'pid',
        'fnChildrens' => 'childrens',
        'fnHeader' => 'header',
        'fnLevel' => 'level',
        'idOfTheRoot' => 0,
        'returnOnly' => null, // Массив полей необходимых пользователю
        'clearFromNonRoot' => true,
        'rootName' => 'Нет родителя (этот элемент корневой)',
        'forSelect' => false,
    ];

    private static function mergeOptions($options = [])
    {
        if ($options === null) {
            $options = self::$treeDefOptions;
        } else {
            $options = array_merge(self::$treeDefOptions, $options);
        }
        return $options;
    }

    public static function treeMulti($options = [])
    {
        $options = self::mergeOptions($options);
        $array = self::find()->asArray()->all();
        return self::toMulti($array, $options);
    }

    public static function treeDimen($options = [])
    {
        $options = self::mergeOptions($options);
        $multi = self::treeMulti($options);
        return self::toDimen($multi, $options);
    }

    public static function treeSelect($options = [])
    {
        $options = self::mergeOptions($options);
        $options['forSelect'] = true;
        $dimen = self::treeDimen($options);
        $select = array_column($dimen, $options['fnHeader'], $options['fnId']);
        return $select = [0 => $options['rootName']] + $select;
    }

    public function treeMultiWithout($options = [])
    {
        $options = self::mergeOptions($options);
        $array = self::find()->where(['<>', $options['fnId'], $this->{$options['fnId']}])->asArray()->all();
        $options['clearFromNonRoot'] = true;
        return self::toMulti($array, $options);
    }

    public function treeDimenWithout($options = [])
    {
        $options = self::mergeOptions($options);
        $multi = $this->treeMultiWithout($options);
        return self::toDimen($multi, $options);
    }

    public function treeSelectWithout($options = [])
    {
        $options = self::mergeOptions($options);
        $options['forSelect'] = true;
        $dimen = $this->treeDimenWithout($options);
        $select = array_column($dimen, $options['fnHeader'], $options['fnId']);
        return [null => $options['rootName']] + $select;
    }

    public static function toDimen($array, $options = [])
    {
        $options = self::mergeOptions($options);
        $dimen = [];
        $level = 1;
        $parentMulti[$level] = $array;
        $parentCount[$level] = count($array);
        $parentIndex[$level] = 0;
        while ($level >= 1) {
            $mode = each($parentMulti[$level]);
            if ($mode !== false) {
                $parentIndex[$level] ++;
                $temp = $mode[1];
                unset($temp[$options['fnChildrens']]);
                if ($options['forSelect']) {
                    $pre = '';
                    for ($l=1; $l < $level; $l++) { 
                        $pre.= ($parentCount[$l]===$parentIndex[$l])?"   ":"┃  ";
                    }
                    $pre.= (($parentIndex[$level]) === $parentCount[$level])?"┗━":"┣━";
                    $pre.= count($mode[1][$options['fnChildrens']])?"━┳":"━━";
                    $temp[$options['fnHeader']] = $pre . $temp[$options['fnHeader']];
                }
                $dimen[$mode[1][$options['fnId']]] = $temp;
                if ( count($mode[1][$options['fnChildrens']]) ) {
                    $level++;
                    $parentMulti[$level] = $mode[1][$options['fnChildrens']];
                    $parentCount[$level] = count($mode[1][$options['fnChildrens']]);
                    $parentIndex[$level] = 0;
                }
            } else {
                $level--;
            }
        }
        return $dimen;
    }

    public static function toMulti($array, $options = [])
    {
        $options = self::mergeOptions($options);
        $return = [];
        $cache = [];
        // Для каждого элемента
        foreach ($array as $key => $value) {
            // Если нет родителя элемента, и элемент не корневой,
            // тогда создаем родителя в возврат а ссылку в кэш
            if (!isset($cache[$value[$options['fnPid']]]) && ($value[$options['fnPid']] != $options['idOfTheRoot'])) {
                if ($options['returnOnly'] === null) {
                    $temp = array_fill_keys(array_keys($value), null);
                } else {
                    $temp = [];
                    foreach ($options['returnOnly'] as $fieldName) {
                        $temp[$fieldName] = $value[$fieldName];
                    }
                }
                $temp[$options['fnId']] = $value[$options['fnPid']];
                $temp[$options['fnPid']] = null;
                $temp[$options['fnChildrens']] = [];
                $return[$value[$options['fnPid']]] = $temp;
                $cache[$value[$options['fnPid']]] = &$return[$value[$options['fnPid']]];
            }
            // Если элемент уже был создан, значит он был чьим-то родителем, тогда
            // обновим в нем информацию о его родителе и все остальное
            if (isset($cache[$value[$options['fnId']]])) {
                if ($options['returnOnly'] === null) {
                    $temp = $value;
                } else {
                    $temp = [];
                    foreach ($options['returnOnly'] as $fieldName) {
                        $temp[$fieldName] = $value[$fieldName];
                    }
                }
                $temp[$options['fnId']] = $value[$options['fnId']];
                $temp[$options['fnPid']] = $value[$options['fnPid']];
                unset($temp[$options['fnChildrens']]); // Кроме чилдренов, а то можем стереть данные детей
                foreach ($temp as $fieldName => $fieldValue) {
                    $cache[$value[$options['fnId']]][$fieldName] = $fieldValue;
                }
                // Если этот элемент не корневой,
                // тогда переместим его в родителя, и обновим ссылку в кэш
                if ($value[$options['fnPid']] != $options['idOfTheRoot']) {
                    $cache[$value[$options['fnPid']]][$options['fnChildrens']][$value[$options['fnId']]] = $return[$value[$options['fnId']]];
                    unset($return[$value[$options['fnId']]]);
                    $cache[$value[$options['fnId']]] = &$cache[$value[$options['fnPid']]][$options['fnChildrens']][$value[$options['fnId']]];
                }
            }
            // Иначе, элемент новый, родитель уже создан, добавим в родителя
            else {
                // Если элемент не корневой - вставляем в родителя беря его из кэш
                if ($value[$options['fnPid']] != $options['idOfTheRoot']) {
                    if ($options['returnOnly'] === null) {
                        $temp = $value;
                    } else {
                        $temp = [];
                        foreach ($options['returnOnly'] as $fieldName) {
                            $temp[$fieldName] = $value[$fieldName];
                        }
                    }
                    $temp[$options['fnChildrens']] = [];
                    // Берем родителя из кэш и вставляем в "детей"
                    $cache[$value[$options['fnPid']]][$options['fnChildrens']][$value[$options['fnId']]] = $temp;
                    // Вставляем в кэш ссылку на элемент
                    $cache[$value[$options['fnId']]] = &$cache[$value[$options['fnPid']]][$options['fnChildrens']][$value[$options['fnId']]];
                }
                // Если элемент кокренвой, вставляем сразу в return и в кэш ссылку
                else {
                    if ($options['returnOnly'] === null) {
                        $temp = $value;
                    } else {
                        $temp = [];
                        foreach ($options['returnOnly'] as $fieldName) {
                            $temp[$fieldName] = $value[$fieldName];
                        }
                    }
                    $temp[$options['fnChildrens']] = [];
                    $return[$value[$options['fnId']]] = $temp;
                    // Вставляем в кэш ссылку на элемент
                    $cache[$value[$options['fnId']]] = &$return[$value[$options['fnId']]];
                }
            }
        }
        if ($options['clearFromNonRoot']) {
            foreach ($return as $key => $value) {
                if ($value[$options['fnHeader']] === null) {
                    unset($return[$key]);
                }
            }
        }
        return $return;
    }

    /**
     * Проверяет наличие детей у узла
     * @return boolean 
     */
    public function treeHasChildren()
    {
        $childrens = self::find()->where([self::$treeSettings['fnPid'] => $this->{self::$treeSettings['fnId']} ])->all();
        if ($childrens) {
            return true;
        }
        return false;
    }
}