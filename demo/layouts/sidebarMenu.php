<?php
/**
 * Created by PhpStorm.
 * User: bianjunping
 * Date: 2019/7/4
 * Time: 5:11 PM
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
?>