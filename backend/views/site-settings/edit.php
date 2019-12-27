<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 20/06/2017
 * Time: 23:08
 */
use common\components\MyExtensions\MyImagePublisher;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = "Редактирование настроки";
?>


<?php $form = ActiveForm::begin(['id' => 'add-author', 'class'=>"m-t",'options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row">


        <div class="col-md-6 col-md-offset-3" >

            <div class="row">




                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Общие данные</h5>

                                </div>
                                <div class="ibox-content">
                                    <div class="row">
                                        <div class="col-md-12">


                                            <?= $form->field($formItem, 'file_name')->fileInput() ?>


                                            <?php
                                            if ($item->file_value) { ?>


                                                <hr>
                                                <img   width="200" src="<?=(new MyImagePublisher($item))->resizeInBox(500,500,false,'file_value')?>" alt="Picture">



                                            <?php }

                                            ?>
                                            <hr>
                                            <?= Html::submitButton('Изменить', ['class' => 'btn btn-outline btn-sm btn-primary pull-right m-t-n-xs', 'name' => 'add-exist-button']) ?>

                                        </div>

                                    </div>
                                </div>
                                <div class="row m-t">
                                    <div class="col-md-12">


                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>





            </div>
        </div>





    </div>

<?php ActiveForm::end(); ?>