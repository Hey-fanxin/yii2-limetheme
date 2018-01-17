<?php
/**
 * Created by PhpStorm.
 * User: bianjunping
 * Date: 2018/1/10
 * Time: 下午2:11
 */

namespace common\widgets;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;
use yii\widgets\ActiveForm;
use yii\bootstrap\ButtonDropdown;
use yii\bootstrap\Button;
use common\widgets\assets\ButtonSelectElePluginAsset;

class ButtonSelectEle extends  \yii\base\widget
{
    use \yii\bootstrap\BootstrapWidgetTrait;

    const _ICON = '<i class="fa fa-sort" aria-hidden="true"></i>';

    const TYPE_COMPONENT_BOOT = 1;

    const TYPE_COMPONENT_CUSTOM = 2;

    const TYPE_COMPONENT_DROPDOWN = 3;

    public $type = self::TYPE_COMPONENT_CUSTOM;

    /**
     * @var ActiveForm the ActiveForm object which you can pass for seamless usage with ActiveForm. This property is
     * especially useful for client validation of [[attribute2]] for [[TYPE_RANGE]] validation.
     */
    public $form;

    public $model;

    public $attribute;


    /**
     * @var array the HTML attributes for the input tag.
     */
    public $options = [];

    /**
     * @inheritdoc
     *
     */
    public $items = [];

    public $pluginName = 'dropdown';

    public $listCss = [];

    /**
     * @var string the button label
     */
    public $label = '请选择';
    /**
     * @var array the HTML attributes for the container tag. The following special options are recognized:
     *
     * - tag: string, defaults to "div", the name of the container tag.
     *
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     * @since 2.0.1
     */
    public $containerOptions = [];



    public function run()
    {
        parent::run();
        ButtonSelectElePluginAsset::register($this->getView());
        return $this->parseMarkup();
    }

    protected function parseMarkup()
    {
        switch ($this->type) {
            case self::TYPE_COMPONENT_CUSTOM:
                return $this->renderCustomDropDown();
            case self:: TYPE_COMPONENT_DROPDOWN:
                return ButtonDropdown::widget([
                'label' => $this->label,
                'dropdown' => [
                    'items' =>$this->items
                ]
            ]);
            case self::TYPE_COMPONENT_BOOT:
                return $this->form->field($this->model,$this->attribute)->dropDownList($this->items[] = $this->label,$this->options);
            default:
                return '';
        }
    }

    protected function renderCustomDropDown()
    {
//        if (empty($this->options['readonly'])) {
//            $this->options['readonly'] = true;
//        }
        // @todo use [[options]] instead of [[containerOptions]] and introduce [[buttonOptions]] before 2.1 release
        Html::addCssClass($this->containerOptions, ['widget' => 'dropdown']);
        $options = $this->containerOptions;
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        if(isset($this->attribute)){
            if (!array_key_exists('id', $options)) {
                $this->options['id'] = Html::getInputId($this->model, $this->attribute);
            }
        }
        $this->registerPlugin('dropdown');
        return implode("\n", [
            Html::beginTag($tag, $options),
            $this->renderButton(),
            $this->renderDropdown(),
            Html::endTag($tag)
        ]);
    }

    /**
     * Generates the button dropdown.
     * @return string the rendering result.
     */
    protected function renderButton()
    {
        $options = $this->options;
        //Html::addCssClass($this->options, ['widget' => 'btn']);
        $icon = self::_ICON;
        Html::addCssClass($options, ['toggle' => 'dropdown-toggle', 'select' => 'btn btn-default btn-select']);
        $options['data-toggle'] = 'dropdown';
        $options['aria-haspopup'] = "true";
        if(isset($this->attribute)){
            $name = isset($options['name']) ? $options['name'] : Html::getInputName($this->model, $this->attribute);
            $value = isset($options['value']) ? $options['value'] : Html::getAttributeValue($this->model, $this->attribute);
            $options['name'] = $name;
            $options['value'] = $value;
        }

        $con = Html::tag('span', $this->label).$icon;
        return Html::tag('button', $con, $options);
    }

    /**
     * Generates the dropdown menu.
     * @return string the rendering result.
     */
    protected function renderDropdown()
    {
        $options = $this->listCss;
        Html::addCssClass($options, ['class' => 'dropdown-menu']);
        if(isset($this->attribute)){
            if (!array_key_exists('id', $options)) {
                $options['id'] =  Html::getInputId($this->model, $this->attribute).'_menu';
            }
        }
            
        $this->registerAssets($options);
        return $this->renderItems($this->items, $options);
    }

    /**
     * Renders menu items.
     * @param array $items the menu items to be rendered
     * @param array $options the container HTML attributes
     * @return string the rendering result.
     * @throws InvalidConfigException if the label option is not specified in one of the items.
     */
    protected function renderItems($items, $options = [])
    {
        $lines = [];
        foreach ($items as $key => $value) {

            $itemOptions = ['data-dropdown-n' => $key];
            $content = Html::tag('a', $value, $itemOptions);

            $lines[] = Html::tag('li', $content);
        }
        return Html::tag('ul', implode("\n", $lines), $options);
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
        if ($this->type < 1 || $this->type > 2 || !is_int($this->type)) {
            static::err("Invalid value for the property 'type'. Must be an integer between 1 and 6.");
        }

//        if (!isset($this->form)) {
//            return;
//        }
//        if (!$this->form instanceof ActiveForm) {
//            static::err("The 'form' property must be of type \\yii\\widgets\\ActiveForm");
//        }
        if (!$this->model) {
            static::err("You must set the 'model' and 'attribute' properties when the 'form' property is set.");
        }
    }
    /**
     * Registers the [[customSelect]] widget client assets.
     */
    public function registerAssets($name, $options = [])
    {
        $view = $this->getView();
        $id = empty($options['id']) ? $this->options['id'] : $options['id'];
        $options = empty($options['evetOptions']) ? '' : Json::htmlEncode($options['evetOptions']);
        //$options['fn'] = 'function(obj) {console.log(obj)}';
        $view->registerJs("jQuery('#{$id}').dropDownMenuSelect({$options})");
    }
    protected function registerPlugin($name)
    {
        $view = $this->getView();

        $id = $this->options['id'];
        if ($this->clientOptions !== false) {
            $options = empty($this->clientOptions) ? '' : Json::htmlEncode($this->clientOptions);
            $js = "jQuery('#$id').$name($options);";
            $view->registerJs($js);
        }

        $this->registerClientEvents();
    }

    /**
     * Registers JS event handlers that are listed in [[clientEvents]].
     * @since 2.0.2
     */
    protected function registerClientEvents()
    {
        if (!empty($this->clientEvents)) {
            $id = $this->options['id'];
            $js = [];
            foreach ($this->clientEvents as $event => $handler) {
                $js[] = "jQuery('#$id').on('$event', $handler);";
            }
            $this->getView()->registerJs(implode("\n", $js));
        }
    }

}