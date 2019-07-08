<?php
/**
 * Created by PhpStorm.
 * User: bianjunping
 * Date: 2019/7/5
 * Time: 1:54 PM
 */

namespace limefamily\limetheme\widgets;

use yii\grid\GridView as BaseWidget;
use yii\helpers\ArrayHelper;

class GridView extends BaseWidget
{
    public $tableOptions = ['class' => 'table table-bordered'];

    public function init()
    {
        parent::init();
    }

    /**
     * Runs the widget.
     */
    public function run()
    {
        parent::run();
    }

    /**
     * {@inheritdoc}
     */
    public function renderSection($name)
    {
        switch ($name) {
            case '{pager}':
                return $this->renderPager();
            default:
                return parent::renderSection($name);
        }
    }

    /**
     * Renders the pager.
     * @return string the rendering result
     */
    public function renderPager()
    {
        $pagination = $this->dataProvider->getPagination();
        if ($pagination === false || $this->dataProvider->getCount() <= 0) {
            return '';
        }
        /* @var $class LinkPager */
        $pager = $this->pager;
        $class = ArrayHelper::remove($pager, 'class', LinkPager::className());
        $pager['pagination'] = $pagination;
        $pager['view'] = $this->getView();

        return $class::widget($pager);
    }
}