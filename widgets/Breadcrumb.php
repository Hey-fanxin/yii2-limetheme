<?php

namespace limefamily\limetheme\widget;

class Breadcrumb extends \yii\widgets\Breadcrumbs {

    public function run()
    {
        parent::run();
        $ivew = $this->getView();
        BreadcrumbsbAsset::register($ivew);
    }
}