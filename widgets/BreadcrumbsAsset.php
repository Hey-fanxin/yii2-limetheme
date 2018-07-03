<?php

namespace limefamily\limetheme\widgets;

use yii\web\AssetBundle;

 /**
 * This asset bundle provides the javascript files for the [[Breadcrumb]] widget.
 *
 */
class BreadcrumbsAsset extends AssetBundle 
{
    public $sourcePath = '@vendor/limefamily/static-theme/dist';
    public $css = [
        'css/component/Breadcrumbs.css',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];
}