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
    * [ViewTreeAsset](#ass_viewtreeasset)
    * [ViewTreeSelectAsset](#ass_viewtreeselectasset)
    * [FormAsset](#ass_formasset)

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
Предоставляет модели методы получающие данные из базы и преобразующие их для удобного вывода в виде дерева.
#### Использование
__Модель__
```
class ...
{
    use \Zlatov\yiiComponents\traits\Tree;

    private static $treeOptions = [
        'fnId' => 'id',
        'fnPid' => 'pid',
        'fnChildrens' => 'childrens',
        'fnHeader' => 'header',
        'fnLevel' => 'level',
        'idOfTheRoot' => null,
        'addRoot' => false,
        'returnOnly' => null,
        'clearFromNonRoot' => true,
        'rootName' => 'Нет родителя (этот элемент корневой)',
        'forSelect' => false,
        'order' => [
            'level' => SORT_ASC,
            'order' => SORT_ASC,
        ],
    ];
```
__Контроллер__
```
    public function actionIndex()
    {
        $sections = Section::treeMulti();

        return $this->render('index', [
            'sections' => $sections,
        ]);
    }
```
__Представление__
```
    <?= Zlatov\yiiComponents\widgets\ViewTree::widget([
        'viewTree' => $sections,
        'options' => [
            'admin' => true,
        ],
        'model' => null
    ]) ?>
```

## Виджеты (widgets)
### ViewTree <a name="wid_viewtree"></a>
## Хелперы (helpers)
### Text <a name="hel_text"></a>
## Ресурсы (assets)
### ViewTreeAsset <a name="ass_viewtreeasset"></a>
```php
<?= ViewTree::widget([
	'ztree' => $current_menu,
	'current_id' => $model->id,
]) ?>
```
### ViewTreeSelectAsset <a name="ass_viewtreeselectasset"></a>
### FormAsset <a name="ass_formasset"></a>
Использование
```
Zlatov\yiiComponents\assets\FormAsset::register($this);
```
