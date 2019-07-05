<?php
/**
 * Created by PhpStorm.
 * User: bianjunping
 * Date: 2019/7/3
 * Time: 11:53 AM
 */

namespace limefamily\limetheme\widgets;

use Symfony\Component\CssSelector\Parser\Handler\HashHandler;
use Yii;
use yii\bootstrap\Widget;
use yii\helpers\Html;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use limefamily\limetheme\web\limefamilyAsset;

class SidebarMenu extends Widget
{
    /**
     * @var array list of items in the nav widget. Each array element represents a single
     * menu item which can be either a string or an array with the following structure:
     *
     * - label: string, required, the nav item label.
     * - url: optional, the item's URL. Defaults to "#".
     * - left-icon: 可以根据 "Font Awesome"或"bootstrap ui自带的" 图标来填充 默认的是："fa-pie-chart".
     * - visible: boolean, optional, whether this menu item is visible. Defaults to true.
     * - linkOptions: array, optional, the HTML attributes of the item's link.
     * - options: array, optional, the HTML attributes of the item container (LI).
     * - small-icon：当没有字列表时可设置对应的标志 类型 "array"
     * - active: boolean, optional, whether the item should be on active state or not.
     * - treeviewMenuOptions: array, optional, the HTML options that will passed to the [[Dropdown]] widget.
     * - items: array|string, optional, the configuration array for creating a [[Dropdown]] widget,
     *   or a string representing the dropdown menu. Note that Bootstrap does not support sub-dropdown menus.
     *
     * If a menu item is a string, it will be rendered directly without HTML encoding.
     */
    public $items = [];
    /**
     * @var boolean whether the nav items labels should be HTML-encoded.
     */
    public $encodeLabels = true;
    /**
     * @var boolean whether to automatically activate items according to whether their route setting
     * matches the currently requested route.
     * @see isItemActive
     */
    public $activateItems = true;
    /**
     * @var boolean whether to activate parent menu items when one of the corresponding child menu items is active.
     */
    public $activateParents = true;
    /**
     * @var string the route used to determine if a menu item is active or not.
     * If not set, it will use the route of the current request.
     * @see params
     * @see isItemActive
     */
    public $route;
    /**
     * @var array the parameters used to determine if a menu item is active or not.
     * If not set, it will use `$_GET`.
     * @see route
     * @see isItemActive
     */
    public $params;
    /**
     * @var string this property allows you to customize the HTML which is used to generate the drop down caret symbol,
     * which is displayed next to the button text to indicate the drop down functionality.
     * Defaults to `null` which means `<b class="caret"></b>` will be used. To disable the caret, set this property to be an empty string.
     */
    public $dropDownCaret;

    public $sidebarMenuClass = ['class' => 'sidebar-menu', 'data-widget' => 'tree'];

    public $pullRightContainerIconClass = 'fa fa-angle-left pull-right';

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        if ($this->route === null && Yii::$app->controller !== null) {
            $this->route = Yii::$app->controller->getRoute();
        }
        if ($this->params === null) {
            $this->params = Yii::$app->request->getQueryParams();
        }
        if ($this->dropDownCaret === null) {
            $this->dropDownCaret = Html::tag('i', '', ['class' => $this->pullRightContainerIconClass]);
        }
        Html::addCssClass($this->options, ['widget' => 'main-sidebar']);
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        limefamilyAsset::register($this->getView());
        return $this->renderItems();
    }

    /**
     * Renders widget items.
     */
    public function renderItems()
    {
        $items = [];
        foreach ($this->items as $i => $item) {
            if (isset($item['visible']) && !$item['visible']) {
                continue;
            }
            $items[] = $this->renderItem($item);
        }
        return Html::tag('aside',
            Html::tag('ul', implode("\n", $items), $this->sidebarMenuClass)
            ,$this->options);
    }

    /**
     * Renders a widget's item.
     * @param string|array $item the item to render.
     * @return string the rendering result.
     * @throws InvalidConfigException
     */
    public function renderItem($item)
    {
        if (is_string($item)) {
            return $item;
        }
        if (!isset($item['label'])) {
            throw new InvalidConfigException("The 'label' option is required.");
        }
        $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
        $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
        $options = ArrayHelper::getValue($item, 'options', []);
        $items = ArrayHelper::getValue($item, 'items');
        $url = ArrayHelper::getValue($item, 'url', '#');
        $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
        $iconClass = ArrayHelper::getValue($item, 'left-icon','fa-pie-chart');
        $icon = Html::tag('i','',['class' => 'fa '.$iconClass]);
        $rightSmallIcon = ArrayHelper::getValue($item, 'small-icon');
        if (isset($item['active'])) {
            $active = ArrayHelper::remove($item, 'active', false);
        } else {
            $active = $this->isItemActive($item);
        }

        if ($items !== null) {
            Html::addCssClass($options, 'treeview');
            $label = Html::tag('span',$label);

            if ($this->dropDownCaret !== '') {
                $label .= Html::tag('span', $this->dropDownCaret,['class' => 'pull-right-container']);
            }
            if (is_array($items)) {
                if ($this->activateItems) {
                    $items = $this->isChildActive($items, $active);
                }
                $items = $this->renderTreeViewMenu($items, $item);
            }
        }else{
            Html::removeCssClass($options, 'treeview');
            $label = Html::tag('span',$label);
            if ($rightSmallIcon !== null) {
                $label .= Html::tag('span', implode("\n",$this->renderSmallIcon($rightSmallIcon)),['class' => 'pull-right-container']);
            }
        }

        if ($this->activateItems && $active) {
            Html::addCssClass($options, 'active');
        }

        $label = $icon.' '.$label;
        return Html::tag('li', Html::a($label, $url, $linkOptions) . $items, $options);
    }

    public function renderTreeViewMenu($items, $parentItem)
    {
        $menuOptions = ArrayHelper::getValue($parentItem, 'treeviewMenuOptions', []);
        Html::addCssClass($menuOptions,'treeview-menu');
        $lines = [];
        foreach ($items as $item) {
            if (isset($item['visible']) && !$item['visible']) {
                continue;
            }
            if (is_string($item)) {
                $lines[] = $item;
                continue;
            }
            if (!array_key_exists('label', $item)) {
                throw new InvalidConfigException("The 'label' option is required.");
            }
            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $itemOptions = ArrayHelper::getValue($item, 'options', []);
            $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
            $url = array_key_exists('url', $item) ? $item['url'] : null;

            if (empty($item['items'])) {
                if ($url === null) {
                    $content = $label;
                    Html::addCssClass($itemOptions, ['widget' => 'menu-header']);
                } else {
                    $content = Html::a(Html::tag('i','',['class' => 'fa fa-circle-o']).$label, $url, $linkOptions);
                }
            }
            $lines[] = Html::tag('li', $content, $itemOptions);
        }
        return Html::tag('ul', implode("\n", $lines), $menuOptions);
    }

    public function renderSmallIcon($arr)
    {
        if (!is_array($arr)){
            return null;
        }
        $smallHtml =  [];
        foreach ($arr as $key => $value) {
            $smallHtml[] = Html::tag('small',$value['label'],['class' => 'label pull-right'.$value['class']]);
        }
        return $smallHtml;
    }
    /**
     * Check to see if a child item is active optionally activating the parent.
     * @param array $items @see items
     * @param boolean $active should the parent be active too
     * @return array @see items
     */
    protected function isChildActive($items, &$active)
    {
        foreach ($items as $i => $child) {
            if (ArrayHelper::remove($items[$i], 'active', false) || $this->isItemActive($child)) {
                Html::addCssClass($items[$i]['options'], 'active');
                if ($this->activateParents) {
                    $active = true;
                }
            }
        }
        return $items;
    }

    /**
     * Checks whether a menu item is active.
     * This is done by checking if [[route]] and [[params]] match that specified in the `url` option of the menu item.
     * When the `url` option of a menu item is specified in terms of an array, its first element is treated
     * as the route for the item and the rest of the elements are the associated parameters.
     * Only when its route and parameters match [[route]] and [[params]], respectively, will a menu item
     * be considered active.
     * @param array $item the menu item to be checked
     * @return boolean whether the menu item is active
     */
    protected function isItemActive($item)
    {

        if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
            $route = $item['url'][0];

            if ($route[0] !== '/' && Yii::$app->controller) {
                $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
            }
            if (ltrim($route, '/') !== $this->route) {
                return false;
            }
            unset($item['url']['#']);
            if (count($item['url']) > 1) {
                $params = $item['url'];
                unset($params[0]);
                foreach ($params as $name => $value) {
                    if ($value !== null && (!isset($this->params[$name]) || $this->params[$name] != $value)) {
                        return false;
                    }
                }
            }

            return true;
        }

        return false;
    }
}