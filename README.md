# yii2-limetheme
Custom theme components and parts of function group

这是一套基于bootstrap框架编写的后台模板主题，和PHP小部件

!["Yii2 Limefamily Presentation"](https://cloud.githubusercontent.com/assets/874234/7603896/753228ee-f943-11e4-9d42-2a31b41eb42d.jpg)

Assets for[Limefamily plugins], So if you want to use any of them we recommend to create a custom bundle where you list the plugin files you need:
```php
use yii\web\AssetBundle;

class LimeFamilyAsset extends AssetBundle
{
    public $sourcePath = '@vendor/limefamily/yii2-limetheme/limetheme/dist';
    public $css = [
        'css/limefamily.min.css',
    ];
    public $js = [
        'js/limefamily-php.min.js'
    ];
}

### Left sidebar menu - Widget Menu

If you need to separate sections of the menu then just add the `li.header` item to `items`
```php
    'items' => [
        ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
        ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
        ['label' => 'MAIN NAVIGATION', 'options' => ['class' => 'header']], // here
        // ... a group items
        ['label' => '', 'options' => ['class' => 'header']],
        // ... a group items
        ['label' => '', 'options' => ['class' => 'header']],
        // ... a group items
```

To add a label for a item:

```php
'items' => [
    [
        'label' => 'Mailbox',
        'icon' => 'envelope-o',
        'url' => ['/mailbox'],
        'template'=>'<a href="{url}">{icon} {label}<span class="pull-right-container"><small class="label pull-right bg-yellow">123</small></span></a>'
    ],
]
```