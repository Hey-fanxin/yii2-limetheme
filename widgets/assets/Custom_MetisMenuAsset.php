<?php
/**
 * Created by PhpStorm.
 * User: bianjunping
 * Date: 2018/1/12
 * Time: 下午5:51
 */

namespace limefamily\widgets\assets;

use yii\web\AssetBundle;

class Custom_MetisMenuAsset extends AssetBundle
{
    public $sourcePath = '@vendor/limefamily/yii2-limetheme/widgets';
    public $js = [
        'js/metisMenu.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}