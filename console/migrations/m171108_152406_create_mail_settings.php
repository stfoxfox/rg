<?php

use yii\db\Migration;
use common\models\SiteSettings;

/**
 * Class m171108_152406_create_mail_settings
 */
class m171108_152406_create_mail_settings extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp() {
        $setting = SiteSettings::findOne(['text_key' => 'smtp_host']);
        if (!$setting) {
            $setting = new SiteSettings([
                'title' => 'Настройки компонентов email',
                'text_key' => 'smtp_host',
                'type' => SiteSettings::SiteSettings_TypeString,
                'string_value' => 'smtp.site.ru',
            ]);
            $setting->save(false);
        }

        $setting = SiteSettings::findOne(['text_key' => 'smtp_username']);
        if (!$setting) {
            $setting = new SiteSettings([
                'title' => 'Настройки компонентов email',
                'text_key' => 'smtp_username',
                'type' => SiteSettings::SiteSettings_TypeString,
                'string_value' => 'username',
            ]);
            $setting->save(false);
        }

        $setting = SiteSettings::findOne(['text_key' => 'smtp_password']);
        if (!$setting) {
            $setting = new SiteSettings([
                'title' => 'Настройки компонентов email',
                'text_key' => 'smtp_password',
                'type' => SiteSettings::SiteSettings_TypeString,
                'string_value' => '',
            ]);
            $setting->save(false);
        }

        $setting = SiteSettings::findOne(['text_key' => 'smtp_port']);
        if (!$setting) {
            $setting = new SiteSettings([
                'title' => 'Настройки компонентов email',
                'text_key' => 'smtp_port',
                'type' => SiteSettings::SiteSettings_TypeString,
                'string_value' => '465',
            ]);
            $setting->save(false);
        }

        $setting = SiteSettings::findOne(['text_key' => 'smtp_encryption']);
        if (!$setting) {
            $setting = new SiteSettings([
                'title' => 'Настройки компонентов email',
                'text_key' => 'smtp_encryption',
                'type' => SiteSettings::SiteSettings_TypeString,
                'string_value' => 'ssl',
            ]);
            $setting->save(false);
        }

    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171108_152406_create_mail_settings cannot be reverted.\n";

        return true;
    }
}
