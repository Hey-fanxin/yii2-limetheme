<?php

namespace limefamily\widgets;

use yii\helpers\Html;
use yii\data\Pagination;
use limefamily\widgets\assets\Pagination;
/**
 * 自定义分页小部件
 */
class LinkPager extends \yii\widgets\LinkPager
{
    //除去首末页连续显示的按钮数目
    public $maxButtonCount = 5;
    public $prevPageLabel = '<i class="fa fa-angle-left" aria-hidden="true"></i>  上一页';
    public $nextPageLabel = '下一页  <i class="fa fa-angle-right" aria-hidden="true"></i>';
    public $prevPageCssClass = 'prev';
    public $nextPageCssClass = 'next';
    public $options = ['class' => 'pagination'];
    public $linkOptions = ['class' => 'link'];
    public $disabledPageCssClass = 'disabled';
    public $activePageCssClass = 'active';
    public $dotCssClass = 'ellipsis';
    
    public function run(){
        if($this->maxButtonCount <= 1){
            $this->maxButtonCount = 5;
        }
        $view = $this->getView();
        Pagination::register($view);

        echo parent::run();
    }
    
    protected function renderPageButtons()
    {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }
    
        $buttons = [];
        $currentPage = $this->pagination->getPage();
    
        // prev page
        if ($this->prevPageLabel !== false) {
            if (($page = $currentPage - 1) < 0) {
                $page = 0;
            }
            $buttons[] = $this->renderPageButton($this->prevPageLabel, $page, $this->prevPageCssClass, $currentPage <= 0, false);
        }
        
        // internal pages
        $endPage = $pageCount - 1;
        if($pageCount <= $this->maxButtonCount + 2){
            for ($i = 0; $i <= $endPage; ++$i) {
                $buttons[] = $this->renderPageButton($i + 1, $i, null, false, $i == $currentPage);
            }
        }else{
            if(($this->maxButtonCount % 2) > 0){
                $left = ($this->maxButtonCount-1)/2;
                $right = $left;
            }else{
                $right = $this->maxButtonCount / 2;
                $left = $right - 1;
            }
            if($currentPage <= $left + 1){
                for($i = 0; $i < $this->maxButtonCount; ++$i){
                    $buttons[] = $this->renderPageButton($i + 1, $i, null, false, $i == $currentPage);
                }
                $buttons[] = $this->renderDot();
                $buttons[] = $this->renderPageButton($endPage + 1, $endPage, null, false, false);
            }elseif($endPage - $currentPage <= $right + 1){
                $buttons[] = $this->renderPageButton(1, 0, null, false, false);
                $buttons[] = $this->renderDot();
                for($i = $endPage + 1 - $this->maxButtonCount; $i <= $endPage; ++$i){
                    $buttons[] = $this->renderPageButton($i + 1, $i, null, false, $i == $currentPage);
                }
            }else{
                $buttons[] = $this->renderPageButton(1, 0, null, false, false);
                $buttons[] = $this->renderDot();
                for($i = $currentPage - $left; $i <= $currentPage; ++$i){
                    $buttons[] = $this->renderPageButton($i + 1, $i, null, false, $i == $currentPage);
                }
                for($i = 1; $i <= $right; ++$i){
                    $buttons[] = $this->renderPageButton($i + $currentPage + 1, $i + $currentPage, null, false, false);
                }
                $buttons[] = $this->renderDot();
                $buttons[] = $this->renderPageButton($endPage + 1, $endPage, null, false, false);
            }
        }
        
    
        // next page
        if ($this->nextPageLabel !== false) {
            if (($page = $currentPage + 1) >= $pageCount - 1) {
                $page = $pageCount - 1;
            }
            $buttons[] = $this->renderPageButton($this->nextPageLabel, $page, $this->nextPageCssClass, $currentPage >= $pageCount - 1, false);
        }
    
        return Html::tag('ul', implode("\n", $buttons), $this->options);
    }
    public function renderDot(){
        $options = ['class' => empty($class) ? $this->dotCssClass : $class];
        return Html::tag('li', '<span class="fa fa-ellipsis-h" aria-hidden="true"></span>', $options);
    }
}