<?php

namespace limefamily\widgets;

use yii\base\Model;
use yii\Helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;

class Search extends \yii\base\widget
{
    public $options = [];

    public $form;

    public $Model;

    public $attribute;
    /**
     * 这是整个搜索框的配置入口
     *
     * search => [
     *      'action'        => '' __默认是 'index',
     *      'method'        => '' __默认是 'post',
     *      'btn_text'      => '' __默认是 '查询'，
     *      'name'          => '' __默认是 'limeSearch',
     *      'value'         => '' __默认是 '',
     *      'placeholder'   => '' __默认是 '搜索条件',
     *      'right'         => '' __默认是 ''              右侧内容区域
     *
     *      'searchInputOptions' => ['class' => 'form-control'],
     *      'searchInputOptions' => ['class' => 'input-group-btn']
     * ]
     *  例子：
     * 'search' => [
     *      'action' => ['index'],
     *      'method' => 'get',
     *      'placeholder' => '姓名/手机号',
     *      'right'  => Html::tag('div',Html::a('新增', ['create'], ['class' => 'btn btn-primary btn-sm btn-block-sm pull-right']),['class' => 'form-group'])
     *  ]
     *
     */
    public $search = [];

    /**
     * @var array the options for rendering the filter error summary.
     * Please refer to [[Html::errorSummary()]] for more details about how to specify the options.
     * @see renderErrors()
     */
    public $filterErrorSummaryOptions = ['class' => 'error-summary'];


    public function run()
    {
        parent::run();
        return $this->renderSearch();
    }

    /**
     * Renders validator errors of filter model.
     * @return string the rendering result.
     */
    public function renderErrors()
    {
        if ($this->model instanceof Model && $this->Model->hasErrors()) {
            return Html::errorSummary($this->model, $this->filterErrorSummaryOptions);
        }

        return '';
    }

    /**
     * Renders SearchForm filter model
     * @return string the rendering result
     */
    public function renderSearch()
    {
        if(empty($this->search)){
            return '';
        }
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        $default_data = $this->initDefaultData();
        $content = $this->createSearchEle();

        $formEle = implode('',[
            Html::beginForm($default_data['action'], $default_data['method'], $this->options),
            $content,
            Html::endForm()
        ]);

        return Html::tag('div',$formEle,['id' => 'search-form-box']);
    }

    /**
     * Genrates the search content element
     * @return string then rendering result.
     */
    public function createSearchEle()
    {
        $default_data = $this->initDefaultData();
        
        $search_submit = Html::tag('span',
            Html::submitButton(Html::tag('i','',['class' => 'fa fa-search']) . $default_data['btn_text'], ['class' => 'btn btn-default'])
        ,$default_data['searchSubmitOptions']);

        $search_input = Html::input('text',$default_data['name'], $default_data['value'], $default_data['searchInputOptions']);

        $search_right = ArrayHelper::remove($search, 'right', '');
        return Html::tag('div',
            Html::tag('div',
                Html::tag('div',$search_input . $search_submit,['class' => 'input-group input-group-default'])
            ,['class' => 'col-lg-6']).
            Html::tag('div',$search_right,['class' => 'col-lg-6'])
        ,['class' => 'row','style' => 'margin-bottom: 10px;']);
    }

    /**
     * Initialize the default data
     * @return array the rendering result.
    */
    public function initDefaultData()
    {
        $search =$this->search;
        $default_data = [
            'action' => 'index',
            'method' => 'post',
            //'name' => 'limeSearch',
            'value' => '',
            'btn_text' => '查询',
            'placeholder' => '搜索条件',
            'searchSubmitOptions' => ['class' => 'input-group-btn'],
            'searchInputOptions' =>  ['class' => 'form-control']
        ];
        // $action = ArrayHelper::remove($search, 'action', 'index');
        // $method = ArrayHelper::remove($search, 'method', 'post');
        // $submit_btn_text = ArrayHelper::remove($search, 'btn_text', '查询');
        // $search_submit_options = ArrayHelper::remove($search, 'searchInputOptions', ['class' => 'input-group-btn']);
        // $search_input_name = ArrayHelper::remove($search, 'name', 'limeSearch');
        // $search_input_value = ArrayHelper::remove($search, 'value', '');
        // $search_input_placeholder = ArrayHelper::remove($search, 'placeholder', '搜索条件');
        // $search_input_options = ArrayHelper::remove($search, 'searchInputOptions', ['class' => 'form-control']);
        
        foreach ($default_data as $key => $value) {
            $default_data[$key] = ArrayHelper::remove($search, $key, $value);
        }
        $default_data['searchInputOptions']['placeholder'] =  $default_data['placeholder'];

        return $default_data;
    }

    public function registerClientScript()
    {
       $id = $this->searchOptions['id'];
       $options = Json::htmlEncode($this->getClientOptions());
       $attributes = Json::htmlEncode(ArrayHelper::remove($this->search, 'attributes', []));
       $view = $this->getView();
       ActiveFormAsset::register($view);
       $view->registerJs("jQuery('#$id').yiiActiveForm($attributes, $options);");
    }
}