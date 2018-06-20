<?php

namespace limefamily\widgets;

use limefamily\widgets\assets\BreadcrumbAsset;

class Breadcrumb extends \yii\widgets\Breadcrumbs {

    public function run()
    {
        $ivew = $this->getView();
        BreadcrumbAsset::register($ivew);
        parent::run();
    }
}