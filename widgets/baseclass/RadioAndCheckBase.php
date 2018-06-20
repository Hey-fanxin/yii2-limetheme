<?php

namespace limefamily\widgets\baseclass;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;
use yii\widgets\ActiveForm;
use limefamily\widgets\assets\RadioAndCheckAsset;
/* radio 和 checked 组件的基类 - */

class RadioAndCheckBase extends  \yii\base\widget
{

    const _ICON = '<i class="fa-li fa fa-lg" aria-hidden="true"></i>';
    /**
     * @var ActiveForm the ActiveForm object which you can pass for seamless usage with ActiveForm. This property is
     * especially useful for client validation of [[attribute2]] for [[TYPE_RANGE]] validation.
     */
    public $form;

    public $model;

    public $attribute;

    public $type = 'text';

    public $items = [];
    /**
     * @var array the HTML attributes for the input tag.
     */
    public $options = [];

    public $labelOptions = [];

    public function run()
    {
        parent::run();

        $view = $this->getView();
        RadioAndCheckAsset::register($view);
        return $this->renderListBox();
    }

    protected function renderListBox() {
        $this->validateConfig();
        $options = $this->options;
        $name = isset($options['name']) ? $options['name'] : Html::getInputName($this->model, $this->attribute);
        $selection = isset($options['value']) ? $options['value'] : Html::getAttributeValue($this->model, $this->attribute);
        if (!array_key_exists('unselect', $options)) {
            $options['unselect'] = '';
        }
        if (!array_key_exists('id', $options)) {
            $options['id'] = Html::getInputId($this->model, $this->attribute);
        }
        return $this->renderList($name, $selection, $this->items, $options);
    }

    protected function renderList($name, $selection, $items, $options) {

        if(!isset($items)) return '';
        $type = $this->type;
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        $separator = ArrayHelper::remove($options, 'separator', "\n");
        $hidden = isset($options['unselect']) ? Html::hiddenInput($name, $options['unselect']) : '';
        unset($options['unselect']);

        $lines = [];
        $index = 0;
        foreach ($items as $value => $label) {
            $checked = $selection !== null &&
                (!ArrayHelper::isTraversable($selection) && !strcmp($value, $selection)
                    || ArrayHelper::isTraversable($selection) && ArrayHelper::isIn($value, $selection));
            $lines[] = $this->renderItems($type, $name, $checked, [
                'value' => $value,
                'label' => Html::encode($label),
            ]);
            $index++;
        }
        $visibleContent = implode($separator, $lines);

        if ($tag === false) {
            return $hidden . $visibleContent;
        }
        return $hidden . Html::tag($tag, $visibleContent, $options);

    }

    protected  function renderItems ($type, $name, $checked = false, $options = []) {

        $_icon = self::_ICON;
        $options['checked'] = (bool) $checked;
        $value = array_key_exists('value', $options) ? $options['value'] : '1';
        if (isset($options['uncheck'])) {
            // add a hidden field so that if the checkbox is not selected, it still submits a value
            $hiddenOptions = [];
            if (isset($options['form'])) {
                $hiddenOptions['form'] = $options['form'];
            }
            $hidden = Html::hiddenInput($name, $options['uncheck'], $hiddenOptions);
            unset($options['uncheck']);
        } else {
            $hidden = '';
        }
        if (isset($options['label'])) {
            $label = $options['label'];
            $labelOptions = isset($options['labelOptions']) ? $options['labelOptions'] : $this->labelOptions;
            unset($options['label'], $options['labelOptions']);
                $content = Html::label(Html::input($type, $name, $value, $options) . $_icon . $label, null, $labelOptions);
            return $hidden . $content;
        }

        return $hidden . Html::input($type, $name, $value, $options);
    }
    /**
     * Raise an invalid configuration exception.
     *
     * @param string $msg the exception message
     *
     * @throws InvalidConfigException
     */
    protected static function err($msg = '')
    {
        throw new InvalidConfigException($msg);
    }
    /**
     * Validates widget configuration.
     *
     * @throws InvalidConfigException
     */
    protected function validateConfig()
    {
        if (!isset($this->form)) {
            return;
        }
        if(!empty($this->items)){
            static::err("We can not live without child elements");
        }
        if (!$this->form instanceof ActiveForm) {
            static::err("The 'form' property must be of type \\yii\\widgets\\ActiveForm");
        }
        if (!$this->model) {
            static::err("You must set the 'model' and 'attribute' properties when the 'form' property is set.");
        }
    }
}