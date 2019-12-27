<?php
use yii\helpers\Html;
use common\models\News;
use common\components\MyExtensions\MyHelper;

/**
 * @var $this \yii\web\View
 * @var $model \common\widgets\news\forms\NewsWidgetForm
 * @var $block \common\models\PageBlock
 */

$news = News::getByTags($model->tag);
?>

<?=Html::beginTag('article', [
    'id' => ($block->page->show_anchors && $model->anchor) ? $model->anchor : ''
])?>
    <div class="block_news block_news--about">
        <div class="row">

            <?php foreach ($news as $news_item) :?>
                <div class="col-6">
                    <div class="block_news__item">
                        <?=Html::tag('span', $news_item->news_date, ['class' => 'text--xs block_news__date'])?>
                        <?=Html::tag('h4', $news_item->short_text, ['class' => 'title--m block_news__title'])?>
                        <div class="block_news__description">
                            <?=Html::tag('p', MyHelper::formatTextToHTML($news_item->full_text))?>
                        </div>
                    </div>
                </div>
            <?php endforeach?>

        </div>

        <div class="row">
            <div class="col-4">
                <?=Html::a(Html::tag('span', $model->link_title, ['class' => 'btn__label']), $model->link, [
                    'class' => 'btn btn--small',
                    'target' => '_blank',
                ])?>
            </div>
        </div>

    </div>
<?=Html::endTag('article')?>