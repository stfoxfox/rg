<?php

namespace backend\widgets\crop;
use common\SharedAssets\CroperAsset;
use yii\helpers\BaseHtml;
use yii\web\View;

/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 08/08/2017
 * Time: 13:46
 */
class CropImageWidget extends \yii\base\Widget
{


    public $ratio = 1;
    public $fileAttribute='file_name';
    public $related_model_path ="temp";
    public $form;
    public $model;

    public $x_field;
    public $y_field;
    public $w_field ;
    public $h_field ;




    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub

        if(!$this->x_field || !$this->y_field || !$this->w_field || !$this->h_field){
            $this->x_field = $this->fileAttribute."_x";
            $this->y_field = $this->fileAttribute."_y";
            $this->h_field = $this->fileAttribute."_h";
            $this->w_field = $this->fileAttribute."_w";
        }





    }

    public function run()
    {
        parent::run(); // TODO: Change the autogenerated stub


        CroperAsset::register($this->view);


        $field_id = BaseHtml::getInputId($this->form,$this->fileAttribute);
        $html_id_addon=BaseHtml::getInputId($this->form,$this->fileAttribute)."_";


        $x_arrtibute_id = BaseHtml::getInputId($this->form, $this->x_field);
        $y_arrtibute_id = BaseHtml::getInputId($this->form, $this->y_field);
        $w_arrtibute_id = BaseHtml::getInputId($this->form, $this->w_field);
        $h_arrtibute_id = BaseHtml::getInputId($this->form, $this->h_field);



        $ratio_string =    ($this->ratio==0)?"":"aspectRatio:{$this->ratio},";


        $this->view->registerJs("
       


   
        if (window.FileReader) {
            $('#{$field_id}').change(function() {
                var fileReader = new FileReader(),
                files = this.files,
                file;

            if (!files.length) {
                return;
            }

            file = files[0];

            if (/^image\/\w+$/.test(file.type)) {
                    fileReader.readAsDataURL(file);
                    fileReader.onload = function () {
                        $('#{$html_id_addon}image-div').fadeIn(300);
                     
                        $('#{$html_id_addon}crop_img').cropper({
                        {$ratio_string}
                     
                        minContainerHeight:300,

                        crop: function(data) {
                         
                            {$this->fileAttribute}_{$this->getId()}_showCoords(data);
                        }
                    }).cropper('reset', true).cropper('replace', this.result);
                };
                } else {
                    showMessage('Please choose an image file.');
                }
        });

        } else {
            $('#{$field_id}').addClass('hide');
        }


        function {$this->fileAttribute}_{$this->getId()}_showCoords(c) {
            $('#{$x_arrtibute_id}').val(c.x);
            $('#{$y_arrtibute_id}').val(c.y);
            $('#{$h_arrtibute_id}').val(c.height);
            $('#{$w_arrtibute_id}').val(c.width);
        }", View::POS_READY,get_called_class() . $this->getId());

        return $this->render('view',['widget'=>$this]);


    }

}