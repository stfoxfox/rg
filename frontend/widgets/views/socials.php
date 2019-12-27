<?php
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var string $title
 */
?>

<?=Html::tag('h5', $title, ['class' => 'title--m'])?>
<div class="block_social">
    <a class="block_social__item block_social__item--fb" href="#" title="Facebook">
        <svg class="flat__social_icon icon-social-fb" width="51px" height="51px">
            <use xlink:href="#icon-social-fb"></use>
        </svg>
    </a>
    <a class="block_social__item block_social__item--tw" href="#" title="Twitter">
        <svg class="flat__social_icon icon-social-tw" width="51px" height="51px">
            <use xlink:href="#icon-social-tw"></use>
        </svg>
    </a>
    <a class="block_social__item block_social__item--ok" href="#" title="Одноклассники">
        <svg class="flat__social_icon icon-social-ok" width="51px" height="51px">
            <use xlink:href="#icon-social-ok"></use>
        </svg>
    </a>
    <a class="block_social__item block_social__item--vk" href="#" title="Вконтакте">
        <svg class="flat__social_icon icon-social-vk" width="51px" height="51px">
            <use xlink:href="#icon-social-vk"></use>
        </svg>
    </a>
</div>
