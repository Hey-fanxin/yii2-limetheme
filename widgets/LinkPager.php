<?php
/**
 * Created by PhpStorm.
 * User: bianjunping
 * Date: 2019/7/5
 * Time: 2:08 PM
 */

namespace limefamily\limetheme\widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\LinkPager as BaseWidget;

class LinkPager  extends BaseWidget
{
    public $pagination;

    public $prevPageLabelIcon = true;
    public $nextPageLabelIcon = true;

    public $options = ['class' => 'lime-pagination'];

    public $linkOptions = ['class' => 'link'];

    public $firstPageLabel = '首页';
    public $prevPageLabel = '前一页';
    public $nextPageLabel = '下一页';
    public $lastPageLabel = '末页';
    private $pagerDot = true;

    /**
     * Initializes the pager.
     */
    public function init()
    {
        parent::init();

        if ($this->prevPageLabelIcon !== false){
            $this->prevPageLabelIcon = Html::tag('i','',['class' => 'fa fa-angle-left', 'aria-hidden' => 'true']);
        }
        if ($this->nextPageLabelIcon !== false){
            $this->nextPageLabelIcon = Html::tag('i','',['class' => 'fa fa-angle-right', 'aria-hidden' => 'true']);
        }
    }

    /**
     * Executes the widget.
     * This overrides the parent implementation by displaying the generated page buttons.
     */
    public function run()
    {
        parent::run();
    }

    /**
     * Renders the page buttons.
     * @return string the rendering result
     */
    protected function renderPageButtons()
    {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }

        $buttons = [];
        $currentPage = $this->pagination->getPage();

        // first page
        $firstPageLabel = $this->firstPageLabel === true ? '1' : $this->firstPageLabel;
        if ($firstPageLabel !== false) {
            $buttons[] = $this->renderPageButton($firstPageLabel, 0, $this->firstPageCssClass, $currentPage <= 0, false);
        }

        // prev page
        if ($this->prevPageLabel !== false) {
            if (($page = $currentPage - 1) < 0) {
                $page = 0;
            }
            $buttons[] = $this->renderPageButton($this->prevPageLabelIcon.''.$this->prevPageLabel, $page, $this->prevPageCssClass, $currentPage <= 0, false);
        }

        // internal pages
        list($beginPage, $endPage) = $this->getPageRange();
        if ($beginPage != 0 && $this->pagerDot) {
           $buttons[] = Html::tag('li',Html::tag('i','',['class' => 'fa fa-ellipsis-h', 'aria-hidden' => 'true']),['class' => 'pager-dot']);
        }
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            $buttons[] = $this->renderPageButton($i + 1, $i, null, $this->disableCurrentPageButton && $i == $currentPage, $i == $currentPage);
        }
        if ($endPage != $pageCount && $this->pagerDot) {
            $buttons[] = Html::tag('li',Html::tag('i','',['class' => 'fa fa-ellipsis-h', 'aria-hidden' => 'true']),['class' => 'pager-dot']);
        }
        // next page
        if ($this->nextPageLabel !== false) {
            if (($page = $currentPage + 1) >= $pageCount - 1) {
                $page = $pageCount - 1;
            }
            $buttons[] = $this->renderPageButton($this->nextPageLabel.''.$this->nextPageLabelIcon, $page, $this->nextPageCssClass, $currentPage >= $pageCount - 1, false);
        }

        // last page
        $lastPageLabel = $this->lastPageLabel === true ? $pageCount : $this->lastPageLabel;
        if ($lastPageLabel !== false) {
            $buttons[] = $this->renderPageButton($lastPageLabel, $pageCount - 1, $this->lastPageCssClass, $currentPage >= $pageCount - 1, false);
        }

        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'ul');
        return Html::tag($tag, implode("\n", $buttons), $options);
    }
}