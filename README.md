# yii2-limetheme
Custom theme components and parts of function group

这是一套基于bootstrap框架编写的后台模板主题，和PHP小部件

!["Yii2 Limefamily Presentation"](https://github.com/namebjp/yii2-limetheme/blob/master/images/limefamilyBackend.png)
资产.Limefamily plugins.依赖加载 :
```php
use yii\web\AssetBundle;

class LimeFamilyAsset extends AssetBundle
{
    public $sourcePath = '@vendor/limefamily/static-theme/dist';
    public $css = [
        'css/limefamily.min.css',
        'css/limefamily-skins.min.css',
    ];
    public $js = [
        'js/limefamily.min.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
```

### 左侧 sidebarMenu 组件示例:

左侧 SidebarMenu 组件调用和数据事例
```php
    /**
     * $pparam 'itmes'. 数组内字段包括(详情去查看组件源码)：
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
    */
    $menuItems = array();
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => '登录', 'url' => ['/site/login']];
    } else {
        $menuItems = Yii::$app->user->identity->getAssignedMenu();
        $products = Yii::$app->user->identity->getAssignedProducts();
        $menuItems[] = ['label' => Yii::$app->user->identity->true_name,
            'left-icon' => 'fa-cog',
            'items' =>[
                ['label' => '修改密码', 'url' => ['/site/reset-password']],
                ['label' => '退出 (' . Yii::$app->user->identity->login_code . ')', 'url' => ['/site/logout']],
            ]
        ];
    }
    echo limefamily\limetheme\widgets\SidebarMenu::widget([
        'items' => $menuItems
    ])
```

### 单一条件搜索框示例：
多配合ActiveForm小部件应用，使用示例：
```php
    use ActiveForm;

    $form = ActiveForm::begin(['id' => 'search','method'=>'get','action'=>'index.php?r=***']);
    echo limefamily\limetheme\widgets\SearchComponent::widget([
        'placeholder'=>'客户姓名/合同编号',
        'searchName'=>'param',
        'inputOptions'=>['value'=>isset($searchParams['param']) ? $searchParams['param'] : ''],
    ]);
    ActiveForm::end();
```

### 在GridView 中使用分页组件：
```php
    GridView::widget([
        'dataProvider' => $dataProvider,
        'pager'=>[
           'class'=>'limefamily\limetheme\widgets\LinkPager',
        ],
        ...
    ])
    或直接用：（使用默认配置）
    limefamily\limetheme\widgets\GridView::widget([
        'dataProvider' => $dataProvider,
        ...
    ])
```
