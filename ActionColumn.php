<?php

namespace dixonsatit\actioncolumn;

/**
 * Yii2-ActionColumn
 * action column for ajax delete
 * @author Sathit Seethaphon <dmeroff@gmail.com>
 */

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn as BaseActionColumn;

/**
 * Action column.
 */
class ActionColumn extends BaseActionColumn
{
   public $pjaxId = 'w0';

   public function init()
   {
       parent::init();
       Yii::$app->controller->getView()->registerJs("
        $('.btn-ajax-delete').on('click', function(e) {
            var deleteUrl = $(this).data('url');
            var pjaxContainer = $(this).data('pjaxid');
            $.ajax({
                url: deleteUrl,
                type: 'post',
                dataType: 'json'
            }).done(function(data) {
                $.pjax.reload({container: '#' + $.trim(pjaxContainer)});
            });
            e.preventDefault();
        });
       ");
   }

    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', 'eye-open');
        $this->initDefaultButton('update', 'pencil');
        $this->initDefaultButton('delete', 'trash', [
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
            'data-method' => 'post',
            'class' => 'btn-ajax-delete'
        ]);
    }

   protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {

            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {
                $title = Yii::t('yii', ucfirst($name));
                $options = array_merge([
                    'title' => $title,
                    'aria-label' => $title,
                    'data'=>[
                        'pjax'=>'0',
                        'url'=> $url,
                        'pjaxid'=> $this->pjaxId
                    ]
                ], $additionalOptions, $this->buttonOptions);
                $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-$iconName"]);
                return Html::a($icon, ($name=='delete' ? '#' : $url), $options);
            };

        }
    }
}
