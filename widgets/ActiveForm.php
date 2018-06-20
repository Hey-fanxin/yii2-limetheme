<?php
/**
 * 
 * 
 */

namespace limefamily\widgets;

//use limefamily\w
use yii\widget\ActiveForm as YiiActiveForm;

class ActiveForm extends YiiActiveForm
{
    /**
     * @var string the default field class name when calling [[field()]] to create a new field.
     * @see fieldConfig
     */
    public $fieldClass = 'ActiveField';

    public function init()
    {
        
        parent::init();
        $this->registerAssets();
    }
}