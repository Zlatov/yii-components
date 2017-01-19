<?php
namespace Zlatov\yiiComponents\behaviors;

use yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use Zlatov\yiiComponents\helpers\Text;

class Sid extends Behavior
{
    public $in_attribute = 'header';
    public $out_attribute = 'sid';
    public $translit = true;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'genSid'
        ];
    }

    public function genSid($event)
    {
        if ( empty( $this->owner->{$this->out_attribute} ) ) {
            $this->owner->{$this->out_attribute} = Text::translit( $this->owner->{$this->in_attribute} );
        } else {
            $this->owner->{$this->out_attribute} = Text::translit( $this->owner->{$this->out_attribute} );
        }
    }
}