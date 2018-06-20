<?php
/**
 * 
 * 
 */

namespace limefamily\widgets;

use Yii;
use yii\base\Component;
use yii\base\ErrorHandler;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widget\ActiveField as YiiActiveField;

/**
 * ActiveField represents a form input field within an [[ActiveForm]] and extends the [[YiiActiveField]] component
 * to handle various bootstrap functionality like form types, input groups/addons, toggle buttons, feedback icons, and
 * other enhancements
 */
class ActiveField extends YiiActiveField
{
    /**
     * @var string the default field class name when calling [[field()]] to create a new field.
     * @see fieldConfig
     */
    public $fieldClass = 'ActiveField';

    protected $searchOptions = ['class' => 'input-group input-group-default'];
    protected $buttonOptions = ['class' => 'btn btn-default'];
    protected $inputOptions = ['placeholder' => '搜索条件'];
    public $rgiht = '';

    public function searchList($items, $options)
    {
        $this->parts['{input}'] = Html::tag('div');
        return $this;
    }

    /**
     * Createdy by search template object
     * @return $this the field object itself.
     * 
    */
    public function search($options = [])
    {
        $sarch = $this->renderSearch($options);
        $right = ArrayHelper::remove($options, 'right', $this->right);

        $content = Html::tag('div',
            Html::tag('div', $search, ['class' => 'col-lg-6']) .
            Html::tag('div',$right,['class' => 'col-lg-6'])
        ,['class' => 'row','style' => 'margin-bottom: 10px;']);

        $this->parts['{input}'] = $content;

        return $this;
    }

    /**
     * Createdy by Search Module Element
     * @return string
    */
    protected function renderSearch($options)
    {
        $inputOptions = ArrayHelper::remove($options, 'inputOptions', $this->inputOptions);
        $buttonOptions = ArrayHelper::remove($options, 'buttonOptions', $this->buttonOptions);
        $searchOptions = ArrayHelper::remove($options, 'searchOptions', $this->searchOptions);

        $search_submit = Html::tag('span',
            Html::submitButton(Html::tag('i','',['class' => 'fa fa-search']) . '查询', $buttonOptions)
        ,['class' => 'input-group-btn']);

        return Html::tag('div',
            parent::textInput($inputOptions). $search_submit
        ,$searchOptions);
    }
}