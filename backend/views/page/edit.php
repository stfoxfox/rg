<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\widgets\select2\Select2Widget;



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
                                <?= $form->field($formItem, 'type')->widget(Select2Widget::className(), [
                                    'items' => \common\models\Page::getAttributeEnums('type'),
                                    'options' => [
                                        'class' => 'form-control m-r',
                                        'style' => 'width: 100%',
                                    ],
                                ]) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row m-t">
                        <div class="col-md-12">
                            <?= Html::submitButton('Изменить', ['class' => 'btn btn-outline btn-sm btn-primary pull-right m-t-n-xs', 'name' => 'add-exist-button']) ?>
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
                        <h5>Контент</h5>

                    </div>
                    <div class="ibox-content">

                        <div class="m-b">  <?= $form->field($formItem, 'show_anchors')->checkbox() ?></div>
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
                        <div class="m-t m-b" ><a href="<?=Url::toRoute(['blocks','id'=>$item->id])?>"?>Управление блоками страницы</a></div>
                    </div>
                </div>
            </div>
        </div>


    </div>


</div>
<?php ActiveForm::end(); ?>



