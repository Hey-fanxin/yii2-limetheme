<?php
/**
 * Created by bianjunping  on 2018/4/26.
 * RadioAdnCheck
 * ----------------------------------
 * 
*/
namespace limefamily\widgets\assets;

use yii\web\AssetBundle;

class RadioAndCheckAsset extends AssetBundle
{
    public $sourcePath = '@vendor/limefamily/yii2-limetheme/limetheme/dist';
    public $css = [
        'css/component/radioAndCheck.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];
}