<?php
/**
 * Created by bianjunping on 2018/4/26.
 * 
 * 
*/
namespace limefamily\widgets;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use limefamily\widgets\assets\NavBarAsset;

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/limefamilytheme/limethemestatic/limetheme/dist');

class NavBar extends \yii\base\widget
{
    public $options = ["class" => "navbar"];

    public $title = '清檬客户管理系统';

    public $adminName = 'admin';

    public $out_url = '/site/logout';

    //  判断是否在登录状态中 显示登录人和退出按钮
    public $is_login = false;

    public function run()
    {
        parent::run();
        return $this->navBox();
    }

    public function navBox()
    {
        $view = $this->getView();
        NavBarAsset::register($view);

        $options   = $this->options;
        $headerBox = $this->headerBox($options);
        $rightBox  = $this->rightBox($options);
        $routerBox = $this->routerBox($options);
        
        return Html::tag('nav', $headerBox . $rightBox . $routerBox, $options);
    }
    public function headerBox($options)
    {
        $headerOptions = ArrayHelper::remove($options, 'headerOptions', ['class' => 'navbar-header']);
        $buttonEle = Html::button(
            Html::tag('span','Toggle navigation',["class" => "sr-only"]) .
            Html::tag('span','',["class" => "icon-bar"]) .
            Html::tag('span','',["class" => "icon-bar"]) .
            Html::tag('span','',["class" => "icon-bar"])
        ,['class' =>"navbar-toggle", 'data-toggle' => "push-menu"]);

        return Html::tag('div',
            Html::tag('a', Html::img($directoryAsset . '/images/logo.png', ['alt' => 'logo'])) . $buttonEle            
        ,$headerOptions);
    }
    public function rightBox($options)
    {
        $rightOptions = ArrayHelper::remove($options, 'rightOptions', ['class' => 'navbar-right']);

        $adminBox = $this->is_login ? $this->adminBox() : '';

        return Html::tag('div',
            Html::tag('h4',$this->title) . $adminBox
        ,$rightOptions);
    }
    public function adminBox()
    {
        $conent = Html::tag('div',
            Html::img($directoryAsset . '/images/perpon.png',["alt" => "person"])
        ,['class' => 'avatar']);

        $conent += Html::tag('div',
            Html::tag('span', '你好') .
            Html::tag('span', $this->adminName . '同学')
        ,["class" => "name"]);

        $conent += Html::tag('div',
            Html::a('退出', $this->out_url)
        ,["class" => "out"]);

        return Html::tag('div', $conent ,['class' => 'avatar-box']);
    }
    public function routerBox($options)
    {
        $routerOptions = ArrayHelper::remove($options, 'routerOptions', ['class' => 'navbar-route']);
        return Html::tag('div',
            Breadcrumb::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ])
        ,$routerOptions);
    }
}