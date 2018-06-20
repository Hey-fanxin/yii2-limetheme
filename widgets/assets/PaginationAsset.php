<?php

namespace limefamily\widgets\assets;

use yii\web\AssetBundle;

class PaginationAsset extends AssetBundle
{
    public $sourcePath = '@vendor/limefamily/yii2-limetheme/limetheme/dist';
    public $css = [
        'css/component/pagination.css',
    ];
    public $js = [];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];
} 