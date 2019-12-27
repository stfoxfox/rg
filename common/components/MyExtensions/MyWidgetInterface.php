<?php

namespace common\components\MyExtensions;

interface MyWidgetInterface
{
    /**
     * Gives fields types
     * @return string BlockName
     */
    public static function getBlockName();
	
	/**
     * Gives form model class name
     * @return string Model from name
     */
    public static function getForm();

    public function backendCreate();

    public function backendView($page_block);
}