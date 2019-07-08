<?php
/**
 * Created by PhpStorm.
 * User: bianjunping
 * Date: 2019/7/5
 * Time: 5:36 PM
 */

namespace limefamily\limetheme\widgets;

use yii\base\Widget;
use yii\helpers\Html;
/**
 * 自定义搜索框小部件
 * 多配合ActiveForm小部件应用，使用示例：
 * <?php echo SearchButton::widget([
 *      'placeholder'=>'客户姓名/客户编号',
 *      'searchName'=>'search-param',
 *      'inputOptions'=>['value'=>'可显示已输入的搜索内容'],
 *      'buttonOptions'=>['type'=>'submit']]);?>
 *
 * @param $searchName string 搜索输入框控件名称，即input标签的name属性值
 * @param $withPlaceholder boolean 是否显示占位符，默认为true显示
 * @param $placeholder string 占位符内容，默认为“请输入查询内容...”
 * @param $buttonValue string 查询按钮显示的文字，默认为“查询”
 * @param $withGlyphicon boolean 查询按钮内是否要显示文字图标，默认为true显示
 * @param $glyphicon string 查询按钮内要显示的文字图标class，默认为glyphicon glyphicon-search
 * @param $options array 小部件最外层容器div的配置信息
 * @param $inputOptions array 输入框input的配置信息
 * @param $buttonOptions array 查询按钮的配置信息
 */

class SearchComponent extends Widget
{
    public $searchName = '';
    public $withPlaceholder = true;
    public $placeholder = '请输入查询内容...';

    public $buttonValue = '查询';

    public $withGlyphicon = true;
    public $glyphicon = 'fa fa-search';

    public $options = [];
    public $buttonOptions = [];
    public $inputOptions = [];

    public function init(){
        parent::init();
        $defaultOptions = ['class'=>'input-group input-group-default form-search'];
        if(isset($this->options)){
            $this->options = array_merge($defaultOptions,$this->options);
        }else{
            $this->options = $defaultOptions;
        }
    }

    public function run(){
        $input = $this->renderInput();
        $button = $this->renderButton();
        return Html::tag('div',$input.$button,$this->options);
    }

    private function renderInput(){
        $options = ['class' => 'form-control'];
        if($this->withPlaceholder){
            $options['placeholder'] = $this->placeholder;
        }
        if(isset($this->inputOptions)){
            $options = array_merge($options,$this->inputOptions);
        }
        return Html::input('text',$this->searchName,$options['value'],$options);
    }

    private function renderButton(){
        $options = ['class' => 'input-group-btn'];
        if(isset($this->buttonOptions)){
            $options = array_merge($options,$this->buttonOptions);
        }
        $content = $this->buttonValue;
        if($this->withGlyphicon){
            $content = Html::tag('i','',['class' => $this->glyphicon]).''.$content;
        }
        return Html::tag('span',Html::submitButton($content,['class'=> 'btn btn-default btn-smin']),$options);
    }
}