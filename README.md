Nested
======
nested for jquery with action

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist claudejanz/yii2-nested "*"
```

or add

```
"claudejanz/yii2-nested": "*"
```

to the require section of your `composer.json` file.


Usage
-----

NestedSortableAction
-------------------

```php
public function actions()
{
    return [
        'save-sortable' => [
            'class' => 'claudejanz\yii2nested\NestedSortableAction',
            //'scenario'=>'editable',  //optional
            'modelclass' => Page::className(),
        ],

    ];
}
```

NestedSortable
-------------------

```php
echo NestedSortable::widget([
    'model' => Page::className(),
    'url' => '/pages/save-sortable',
    'expand' => true,
    'pluginOptions' => [
        'maxDepth' => 2
    ]
]);
```