<?php
namespace Zlatov\yiiComponents\traits;

trait Tree
{
    private static $treeDefOptions = [
        'fnId' => 'id',
        'fnPid' => 'pid',
        'fnChildrens' => 'childrens',
        'fnLevel' => 'level',
        'idOfTheRoot' => 0,
        'returnOnly' => null,
    ];

    // public static function toMultidimensional($array, $options['idOfTheRoot'] = 0, $options['fnPid'] = 'pid')
    public static function toMultidimensional($array, $options = null)
    {
        if ($options === null) {
            $options = self::$treeDefOptions;
        } else {
            $options = array_merge(self::$treeDefOptions, $options);
        }

        $return = [];
        $cache = [];
        // Для каждого элемента
        foreach ($array as $key => $value) {
            // Если нет родителя элемента, и элемент не корневой,
            // тогда создаем родителя в возврат а ссылку в кэш
            if (!isset($cache[$value[$options['fnPid']]]) && ($value[$options['fnPid']] != $options['idOfTheRoot'])) {
                if ($options['returnOnly'] === null) {
                    $temp = $value;
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
        return $return;
    }
}