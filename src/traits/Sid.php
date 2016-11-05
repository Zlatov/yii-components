<?php
namespace zlatov\yiiComponents\traits

use zlatov\yiiComponents\helpers\Text;
/**
* 
*/
trait Sid
{
	public function sid()
	{
        if ( empty($this->sid) ) {
            $this->sid = mb_substr(Text::translit($this->header), 0, 160);
        }
        else {
            $this->sid = mb_substr(Text::translit($this->sid), 0, 160);
        }
	}
}