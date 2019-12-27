<?php
/**
 * Created by PhpStorm.
 * User: abpopov
 * Date: 30/03/15
 * Time: 23:29
 */

namespace common\widgets\text;

use common\models\CatalogItem;
use common\models\PageBlock;
use Yii;
use common\components\MyExtensions\MyWidget;

class TextWidget extends MyWidget
{   
    public static function getForm(){
        return '\common\widgets\text\forms\TextWidgetForm';
    }

    public static function getBlockName(){
        return 'Текстовый блок';
    }

	public function init(){
        parent::init();
        if($this->page_id == null)
            return false;
	}


    /**
     * @return string
     */
    public function run()
    {

        $model_class = $this->form;
        $model = new $model_class();
        $model->page_id = $this->page_id;
        $model->widget_name = basename($this->className());
        $model->attributes = $this->params;

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}