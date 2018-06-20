<?php
/**
 * Created by bianjunping on 2018/4/26.
 * 
*/
namespace limefamily\widgets\assets;

use yii\web\AssetBundle;

class NavBarAsset extends AssetBundle
{
    public $sourcePath = '@vendor/limefamily/yii2-limetheme/limetheme/dist';
    public $css = [
        'css/component/navBar.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];
}
