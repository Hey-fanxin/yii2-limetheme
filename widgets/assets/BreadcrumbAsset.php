<?php

namespace limefamily\widgets\assets;

use yii\web\AssetBundle;

 /**
 * This asset bundle provides the javascript files for the [[Breadcrumb]] widget.
 *
 */
class BreadcrumbAsset extends AssetBundle 
{
    public $sourcePath = '@vendor/limefamily/yii2-limetheme/limetheme/dist';
    public $css = [
        'css/component/breadcrumb.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];
}