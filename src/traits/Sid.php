<?php
namespace Zlatov\yiiComponents\traits;

use Zlatov\yiiComponents\helpers\Text;

/**
 * Создание строкового идентификатора из другого поля или из себя
 */
trait Sid
{
    /**
     * Пытается создать строковый идентификатор из себя если не пуст или из другого поля
     * @param  string $stringIdentifierName Имя свойства для строкового идентификатора
     * @param  string $sourceName           Имя свойства для создания идентификатора
     * @return bool
     */
    public function sid($stringIdentifierName = 'sid', $sourceName = 'header')
    {
        if ( empty($this->$stringIdentifierName) ) {
            if ( empty($this->$sourceName) ) {
                $this->addError($sourceName, "Источник для строкового идентификатора пуст ($sourceName)");
                return false;
            }
            $this->$stringIdentifierName = mb_substr(Text::translit($this->$sourceName), 0, 160);
        } else {
            $this->$stringIdentifierName = mb_substr(Text::translit($this->$stringIdentifierName), 0, 160);
        }
        if ( empty($this->$stringIdentifierName) ) {
            throw new \Exception("Строковый идентификатор по какой-то причине остался пуст.");
        }
        return true;
    }
}