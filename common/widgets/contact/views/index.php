<?php
use yii\helpers\Html;
use common\models\Contact;
use common\components\MyExtensions\MyHelper;

/**
 * @var $this \yii\web\View
 * @var $model \common\widgets\contact\forms\ContactWidgetForm
 * @var $block \common\models\PageBlock
 */

$left = Contact::findAll($model->contact_left);
$right = Contact::findAll($model->contact_right);
?>

<?=Html::beginTag('article', [
    'id' => ($block->page->show_anchors && $model->anchor) ? $model->anchor : ''
])?>
    <h1 class="title--xxl">Контакты</h1>
    <div class="row">

        <div class="col-8">
            <div class="about_block_contact">

                <?php foreach ($left as $contact) :?>
                    <div class="about_block_contact__item">
                        <p class="text--m">
                            <?=Html::tag('strong', $contact->title, ['class' => 'title--m'])?>
                            <?php if ($contact->address) :?>
                                <br/>Адрес: <?=$contact->address?>
                            <?php endif?>

                            <?php if ($contact->phones) :?>
                                <br/>Телефоны: <?=Html::a($contact->phones, 'tel:' . $contact->phones)?>
                            <?php endif?>

                            <?php if ($contact->hours) :?>
                                <br/>Часы работы: <?=MyHelper::formatTextToHTML($contact->hours)?>
                            <?php endif?>
                        </p>
                    </div>
                <?php endforeach?>

            </div>
        </div>

        <div class="col-4">
            <div class="block_callout">
                <div class="block_callout__inner">

                    <?php foreach ($right as $contact) :?>
                        <?php if ($contact->email) :?>
                            <div class="block_callout__item">
                                <p class="text--m">
                                    <?=$contact->title?>
                                    <br/><?=Html::a($contact->email, 'mailto:' . $contact->email)?>
                                </p>
                            </div>
                        <?php endif?>
                    <?php endforeach?>

                </div>
            </div>
        </div>

    </div>
<?=Html::endTag('article')?>