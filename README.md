# yiiComponents
## Поведения (behaviors)
### Sid
Перед валидацией экземпляра класса генерирует строковый идентификатор из указанного атрибута, тем самым давая возможность в модели указывать строковый идентификатор как необязательное поле при определенных сценариях.

__Использование__
```php
use \Zlatov\yiiComponents\behaviors\Sid;

...

    public function behaviors()
    {
        return [

            ...

            'sid' => [
                'class' => Sid::className(),
                'in_attribute' => 'header',
                'out_attribute' => 'sid',
            ],

            ...

        ];
    }
    
    ...

    public function rules()
    {
        return [
            ...
            ['sid', 'required', 'on' => ['default']],
            ['sid', 'unique', 'on' => ['default']],
            ['sid', 'string', 'max' => 160, 'on' => ['default']],
            ['sid', 'safe', 'on' => [self::SCENARIO_CREATE]],
            ...
        ];
    }
```
## Примеси (traits)
### Sid
### Tree
## Виджеты (widgets)
### ViewTree
## Хелперы (helpers)
### Text
## Ресурсы (Assets)
### ViewTree
```php
<?= ViewTree::widget([
	'ztree' => $current_menu,
	'current_id' => $model->id,
]) ?>
```
### ViewTreeSelect