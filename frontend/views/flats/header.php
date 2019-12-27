<?php
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var \common\models\Complex $complex
 * @var \common\models\Section $section
 * @var \common\models\Section[] $corpuses
 */
?>

<?=$complex->title?>,
<div class="dropdown_title js_dropdown_title">
    <button class="dropdown_title__show js_dropdown_title_show" type="button">
        Корпус <?=$section->corpus_num?>
        <span class="ico--triangle">
            <svg class="icon__triangle" width="13px" height="9px">
                <use xlink:href="#triangle"></use>
            </svg>
        </span>
    </button>
    <div class="dropdown_title__present js_dropdown_title_present">
        <div class="dropdown_title__list">
            <?php foreach ($corpuses as $corpus) {
                echo Html::tag('span', Html::a('Корпус ' . $corpus->corpus_num, ['/flats/corpus', 'id' => $corpus->corpus_num]));
            }?>
        </div>
    </div>
</div>
