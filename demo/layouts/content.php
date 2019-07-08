<div class="content-wrapper">
    <?= yii\widgets\Breadcrumbs::widget(
        [
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [''],
            'options' => ['class' => 'content-router'],
            'itemTemplate' => '<li class="router-item">{link}</li>',
            'activeItemTemplate' => '<li class="router-item active">{link}</li>'
        ]
    ) ?>
    <div class="content">
        <?= $content ?>
    </div>
</div>