<?php

namespace limefamily\widgets;

class RadioList extends  \limefamily\widgets\baseclass\RadioAndCheckBase
{

    public $type = 'radio';
    /**
     * @var array the HTML attributes for the input tag.
     */
    public $options = [];

    public $labelOptions = ['class' => 'radio-custom'];
}