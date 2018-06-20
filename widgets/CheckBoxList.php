<?php
/**
 * Created by PhpStorm.
 * User: bianjunping
 * Date: 2018/1/15
 * Time: 上午11:16
 */

namespace limefamily\widgets;

class CheckBoxList extends  \limefamily\widgets\baseclass\RadioAndCheckBase
{

    public $type = 'checkbox';
    /**
     * @var array the HTML attributes for the input tag.
     */
    public $options = [];

    public $labelOptions = ['class' => 'checkbox-custom'];

}