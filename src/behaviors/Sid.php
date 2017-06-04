<?php
namespace Zlatov\yiiComponents\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use Zlatov\yiiComponents\helpers\Text;

class Sid extends Behavior
{
    public $in_attribute;
    public static $out_attribute = 'sid';

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'calcSid',
        ];
    }

    public function calcSid($event)
    {
        if ( empty($this->owner->{self::$out_attribute}) ) {
            $this->owner->{self::$out_attribute} = Text::translit($this->owner->{$this->in_attribute});
        } else {
            $this->owner->{self::$out_attribute} = Text::translit($this->owner->{self::$out_attribute});
        }
    }

    // TODO: необходимо изменять правила (rules) валидации не в момент выполнения
    // расширяемыйКласс::rules() (до инициализации),
    // а при инициализации интстанса класса, что позволит настраивать $out_attribute, а так же избавит от строчки:
    // return Sid::calcRules(parent::rules());
    public static function calcRules($rules)
    {
        $new_rules = [];
        foreach ($rules as $value) {
            if (is_array($value[0])) {
                $key = array_search(self::$out_attribute, $value[0]);
                if ($key !== false) {
                    unset($value[0][$key]);
                }
                if (count($value[0])) {
                    array_push($new_rules, $value);
                }
            } else {
                if ($value!==self::$out_attribute) {
                    array_push($new_rules, $value);
                }
            }
        }
        return array_merge($new_rules, [
            [self::$out_attribute, 'safe']
        ]);
    }
}
