<?php

/* @var $this \yii\web\View */
/* @var $content string */

use limefamily\limetheme\web\limefamilyAsset;
use yii\helpers\Html;

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/limefamily/static-theme/dist');
limefamilyAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="sidebar-mini skin-primay">
<?php $this->beginBody() ?>
<div class="wrapper">

    <!--  开始渲染 header  -->
    <?= $this->render(
        'header.php',
        ['directoryAsset' => $directoryAsset]
    ) ?>

    <!--  开始渲染 sidebar-menu  -->
    <?= $this->render(
        'sidebarMenu.php'
    )
    ?>

    <!--  开始渲染 content-wrapper  -->
    <?= $this->render(
        'content.php',
        ['content' => $content, 'directoryAsset' => $directoryAsset]
    ) ?>

    <!--  开始渲染 main-footer  -->
    <footer class="main-footer">
        <div class="footer-content">&copy; limefamily <?= date('Y') ?></div>
    </footer>

</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
