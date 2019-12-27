<?php

namespace common\models;

use Yii;
use common\models\gii\BasePage;
use yii\helpers\Json;

/**
 * Class Page
 * @package common\models
 *
 * @inheritdoc
 * @property PageBlock[] $rootBlocks
 */
class Page extends BasePage
{
    const TYPE_MAIN = 0;
    const TYPE_ABOUT = 1;
    const TYPE_CONTACT = 2;

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRootBlocks() {
        return $this->getPageBlocks()->andWhere(['is', 'parent_id', null])->orderBy('sort');
    }

    /**
     * @param $type
     * @return PageBlock
     */
    public function getRootBlock($type) {
        return PageBlock::find()->andWhere([
            'page_id' => $this->id,
            'type' => $type
        ])->andWhere(['is', 'parent_id', null])->one();
    }

    /**
     * @param $type
     * @param $parent_id
     * @return PageBlock
     */
    public function getBlock($type, $parent_id) {
        return PageBlock::findOne([
            'page_id' => $this->id,
            'type' => $type,
            'parent_id' => $parent_id
        ]);
    }

    /**
     * @return array
     */
    public function getAnchors() {
        $items = [];
        if (!$this->show_anchors)
            return $items;

        foreach ($this->rootBlocks as $rootBlock) {
            $params = Json::decode($rootBlock->data);
            if (!$params || !isset($params['params']) || !isset($params['params']['anchor']))
                continue;
            $items []= [
                'anchor' => $params['params']['anchor'],
                'anchor_title' => isset($params['params']['anchor_title']) ? $params['params']['anchor_title'] : 'Без заголовка',
            ];
        }

        return $items;
    }
}
