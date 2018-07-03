<?php

namespace limefamily\limetheme\widgets;

class Breadcrumb extends \yii\widgets\Breadcrumbs {

    public function run()
    {
        parent::run();
        $ivew = $this->getView();
        BreadcrumbsAsset::register($ivew);
    }
}