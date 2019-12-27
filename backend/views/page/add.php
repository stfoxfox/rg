<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 21/06/2017
 * Time: 19:15
 *
 * @var \yii\web\View $this
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;






?>


<?php $form = ActiveForm::begin(['id' => 'add-page', 'class'=>"m-t"]); ?>


<div class="row">

    <div class="col-md-4">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Основная информация</h5>

                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-12">

                                <?= $form->field($formItem, 'title')->textInput() ?>
                                <?= $form->field($formItem, 'description')->textarea() ?>

                                <?= $form->field($formItem, 'slug')->textInput() ?>


                            </div>

                        </div>
                    </div>
                    <div class="row m-t">
                        <div class="col-md-12">

                            <?= Html::submitButton('Добавить', ['class' => 'btn btn-outline btn-sm btn-primary pull-right m-t-n-xs', 'name' => 'add-exist-button']) ?>

                        </div>
                    </div>


                </div>
            </div>
        </div>

    </div>

    <div class="col-md-8">




        <div class="row"><div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Блоки</h5>

                    </div>
                    <div class="ibox-content">

                        <div class="m-t m-b">  <?= $form->field($formItem, 'html_text')->textarea() ?></div>


                    </div>
                </div>
            </div>


        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Блоки</h5>

                    </div>
                    <div class="ibox-content">

                        <div class="m-t m-b" ><p class="lead">Возможность управления блоками появится после создания страницы</p></div>


                    </div>
                </div>
            </div>
        </div>


    </div>


</div>
<?php ActiveForm::end(); ?>



