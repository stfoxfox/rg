<?php

namespace common\components\MyExtensions;

interface WidgetModelInterface
{
    /**
     * Gives fields types
     * @return array of field => type
     * avialable types: multiFileInput, fileInput, textInput, textArea, hiddenInput, passwordInput, checkbox, dropDownList, imageInput, link, gallery
     */
    public static function types();
}