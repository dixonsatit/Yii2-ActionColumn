Yii2 Action Column
==================
Yii2 ajax delete for action column

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist dixonsatit/yii2-actioncolumn "*"
```

or add

```
"dixonsatit/yii2-actioncolumn": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php

<?php Pjax::begin(['id'=>'pjax-id']); ?>    
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            
            // .....

            [
                'class' => 'dixonsatit\actioncolumn\ActionColumn',
                'pjaxId'=>'pjax-id'
            ]
        ],
    ]); ?>
<?php Pjax::end(); ?>

```

in controller change `actionDelete()` to

```
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        //return $this->redirect(['index']);
    }
```
