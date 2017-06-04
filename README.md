# yiiComponents

1. Поведения (behaviors)
    * [Sid](#beh_sid)
2. Примеси (traits)
    * [Sid](#tra_sid)
    * [Tree](#tra_tree)
3. Виджеты (widgets)
    * [ViewTree](#wid_viewtree)
4. Хелперы (helpers)
    * [Text](#hel_text)
5. Ресурсы (assets)
    * [ViewTree](#ass_viewtree)
    * [ViewTreeSelect](#ass_viewtreeselect)

***

## Поведения (behaviors)
### Sid <a name="beh_sid"></a>
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
            ],

            ...

        ];
    }
    
    ...

    public function rules()
    {
        return Sid::calcRules(parent::rules());
    }
```
## Примеси (traits)
### Sid <a name="tra_sid"></a>
### Tree <a name="tra_tree"></a>
## Виджеты (widgets)
### ViewTree <a name="wid_viewtree"></a>
## Хелперы (helpers)
### Text <a name="hel_text"></a>
## Ресурсы (assets)
### ViewTree <a name="ass_viewtree"></a>
```php
<?= ViewTree::widget([
	'ztree' => $current_menu,
	'current_id' => $model->id,
]) ?>
```
### ViewTreeSelect <a name="ass_viewtreeselect"></a>