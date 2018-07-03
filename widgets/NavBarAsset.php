<?php
/**
 * Created by bianjunping on 2018/4/26.
 * 
*/
namespace limefamily\limetheme\widgets;

use yii\web\AssetBundle;

class NavBarAsset extends AssetBundle
{
    public $sourcePath = '@vendor/limefamily/static-theme/dist';
    public $css = [
        'css/component/navBar.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];
}
