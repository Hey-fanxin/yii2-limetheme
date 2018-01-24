<?php
namespace limefamily\web;

use yii\web\AssetBundle;

class LimeFamilyAsset extends AssetBundle
{
    public $sourcePath = '@vendor/limefamily/yii2-limetheme/limetheme/dist';
    public $css = [
        'css/limefamily.min.css',
    ];
    public $js = [
        'js/limefamily-php.min.js'
    ];
}
