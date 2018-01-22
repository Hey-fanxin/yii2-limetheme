<?php
/**
 * Created by PhpStorm.
 * User: bianjunping
 * Date: 2018/1/15
 * Time: 上午11:16
 */

namespace limefamily\widgets;

class CheckBoxListEle extends  RadioListEle
{
    /**
     * @var ActiveForm the ActiveForm object which you can pass for seamless usage with ActiveForm. This property is
     * especially useful for client validation of [[attribute2]] for [[TYPE_RANGE]] validation.
     */

    public $type = 'checkbox';
    /**
     * @var array the HTML attributes for the input tag.
     */
    public $options = [];

    public $labelOptions = ['class' => 'checkbox-custom'];

}