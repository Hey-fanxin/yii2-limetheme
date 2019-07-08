<header class="main-header">
    <a href="<?=Yii::$app->homeUrl?>" class="main-log">
        <span class="log-min">
            <img src="<?= $directoryAsset.'/images/logo1.png'?>" alt="limefamily-log-min">
        </span>
        <span class="log-lg">
            <img src="<?= $directoryAsset.'/images/logo.png'?>" alt="limefamily-log">
        </span>
    </a>
    <nav class="navbar">
        <a href="javascript:(0)" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <!-- <span class="glyphicon glyphicon-th-list"></span> -->
            <i class="fa fa-bars" aria-hidden="true"></i>
            <span class="sr-only">切换导航 sidebar</span>
        </a>
        <h2 class="limefamily-name">
            清檬客户管理系统
        </h2>
        <div class="navbar-customer-menu">
            <div class="avatar">
                <i class="avatar-icon fa fa-user-circle" aria-hidden="true"></i>
                <span>你好</span>
                <span class="customer-name"><?=Yii::$app->user->identity->true_name?></span>
            </div>
            <ul>
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success">5</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>header list items 1</li>
                        <li>header list items 2</li>
                        <li>header list items 3</li>
                        <li>header list items 4</li>
                        <li role="separator" class="divider"></li>
                        <li>header list items 5</li>
                    </ul>
                </li>
            </ul>
            <div class="exit">
                <span>退出</span>
            </div>
        </div>
    </nav>
</header>