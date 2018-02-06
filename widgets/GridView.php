<?php

namespace limefamily\widgets;

use yii;

class GridView extends \yii\grid\GridView 
{

    /*
     * - 触发整体在一个 form 表单下会在组件的外侧添加统一 form 标签 默认是 false 状态
     */
    public $isFilter = false;

    /**
     * @var string the layout that determines how different sections of the grid view should be organized.
     * The following tokens will be replaced with the corresponding section contents:
     *
     * - `{search}`: 
     * - `{summary}`: the summary section. See [[renderSummary()]].
     * - `{errors}`: the filter model error summary. See [[renderErrors()]].
     * - `{items}`: the list items. See [[renderItems()]].
     * - `{sorter}`: the sorter. See [[renderSorter()]].
     * - `{pager}`: the pager. See [[renderPager()]].
     */
    public $layout = "{search}\n{summary}\n{items}\n{pager}";

    public function renderSection($name)
    {
        switch ($name) {
            case '{search}':
                return $this->renderSearch();
            default:
                return parent::renderSection($name);
        }
    }
    public function renderSearch()
    {

    }
}