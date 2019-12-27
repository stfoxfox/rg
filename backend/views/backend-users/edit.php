<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 21/06/2017
 * Time: 19:15
 *
 * @var \yii\web\View $this
 */

use common\components\MyExtensions\MyImagePublisher;
use yii\helpers\Html;
use yii\widgets\ActiveForm;



$this->title = "Измение администратора"

?>


<?php $form = ActiveForm::begin(['id' => 'add-user', 'class'=>"m-t",'options' => ['enctype' => 'multipart/form-data']]); ?>


<div class="row">

    <div class="col-md-5">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Основная информация</h5>

                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-12">




                                <?= $form->field($addForm, 'username')->textInput() ?>
                                <?= $form->field($addForm, 'name')->textInput() ?>

                                <?php




                                // $form->field($editForm, 'types',array())->dropDownList(\common\models\SpotType::getItemsForSelect(),['multiple'=>"multiple",'class'=>'form-control m-r','id'=>"select-types","style"=>"width: 100%"]) ?>

                                <?= $form->field($addForm, 'email')->textInput() ?>
                                <?= $form->field($addForm, 'password')->textInput() ?>

                                <?= $form->field($addForm, 'roles')->checkboxList(\common\models\BackendUser::getRolesForCheckboxes()) ?>


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

    <div class="col-md-4">

        <?=\backend\widgets\crop\CropImageWidget::widget([

                'form'=>$addForm,
                'fileAttribute'=>'file_name',
                'model'=>$item,
                'x_field'=>'x',
                'y_field'=>'y',
                'w_field'=>'w',
                'h_field'=>'h',
                'ratio'=>0
            ]


        )?>



    </div>


</div>
<?php ActiveForm::end(); ?>



