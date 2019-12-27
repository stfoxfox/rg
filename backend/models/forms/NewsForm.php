<?php
namespace backend\models\forms;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use common\models\News;
use common\models\Page;
use common\models\NewsTag;

/**
* This is the model class for News form.
*/
class NewsForm extends Model
{
    public $title;
    public $news_date;
    public $short_text;
    public $full_text;
    public $page_id;
    public $news_tags;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['news_date', 'created_at', 'updated_at'], 'safe'],
            [['full_text'], 'string'],
            [['page_id'], 'required'],
            [['page_id'], 'integer'],
            [['title', 'short_text'], 'string', 'max' => 255],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::className(), 'targetAttribute' => ['page_id' => 'id']],
            ['news_tags', 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return ArrayHelper::merge((new News())->attributeLabels(), [
            'news_tags' => 'Тэги'
        ]);
    }

    /**
     * @param News $item
     */
    public function loadFrom($item) {
        $this->title = $item->title;
        $this->news_date = $item->news_date;
        $this->short_text = $item->short_text;
        $this->full_text = $item->full_text;
        $this->page_id = $item->page_id;
        $this->news_tags = array_keys($item->getNewsTagsList());
    }

    /**
     * @inheritdoc
     * @var News $item
     */
    public function edit($item) {
        if (!$this->validate()) {
            return null;
        }

        $item->title = $this->title;
        $item->news_date = $this->news_date;
        $item->short_text = $this->short_text;
        $item->full_text = $this->full_text;
    
        if ($item->save()) {
            if ($this->news_tags) {
                $item->unlinkAll('tags', true);
                foreach ($this->news_tags as $tag) {
                    $tag = NewsTag::findOne($tag);
                    if ($tag) {
                        $item->link('tags', $tag);
                    }
                }
            }

            return true;
        }

        return null;
    }

    /**
     * @return News|null
     */
    public function create() {
        $item = new News();
        $item->title = $this->title;
        $page = new Page([
            'title' => $this->title,
            'slug' => Inflector::slug($this->title),
            'is_internal' => true,
        ]);

        if ($page->save()) {
            $item->page_id = $page->id;

            if ($item->save()) {
                if ($this->news_tags) {
                    foreach ($this->news_tags as $tag => $title) {
                        $tag = NewsTag::findOne($tag);
                        if ($tag) {
                            $item->link('tags', $tag);
                        }
                    }
                }

                return $item;
            }
        }

        return null;
    }
}
