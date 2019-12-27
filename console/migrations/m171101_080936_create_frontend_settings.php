<?php
use yii\db\Migration;
use common\models\SiteSettings;

class m171101_080936_create_frontend_settings extends Migration
{
    public function safeUp() {
        $front = new SiteSettings([
            'title' => 'Телефон',
            'text_key' => 'phone',
            'type' => SiteSettings::SiteSettings_TypeString,
            'string_value' => '+7 495 181-43-35',
        ]);
        $front->save(false);

        $front = new SiteSettings([
            'title' => 'Facebook ссылка',
            'text_key' => 'facebook',
            'type' => SiteSettings::SiteSettings_TypeString,
            'string_value' => 'https://www.facebook.com/',
        ]);
        $front->save(false);

        $front = new SiteSettings([
            'title' => 'Twitter ссылка',
            'text_key' => 'twitter',
            'type' => SiteSettings::SiteSettings_TypeString,
            'string_value' => 'https://twitter.com/',
        ]);
        $front->save(false);

        $front = new SiteSettings([
            'title' => 'Vkontakte ссылка',
            'text_key' => 'vk',
            'type' => SiteSettings::SiteSettings_TypeString,
            'string_value' => 'https://vk.com/',
        ]);
        $front->save(false);

        $front = new SiteSettings([
            'title' => 'Odnoklassniki ссылка',
            'text_key' => 'ok',
            'type' => SiteSettings::SiteSettings_TypeString,
            'string_value' => 'https://ok.ru/',
        ]);
        $front->save(false);

    }

    public function safeDown() {
        echo "m171101_080936_create_frontend_settings cannot be reverted.\n";

        return true;
    }

}
