<?php

use yii\db\Migration;
use common\models\SiteSettings;

/**
 * Class m171130_033527_create_social_settings
 */
class m171130_033527_create_social_settings extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp() {
        $setting = SiteSettings::findOne(['text_key' => 'vk_client_id']);
        if (!$setting) {
            $setting = new SiteSettings([
                'title' => 'Настройки компонентов авторизации VKontakte',
                'text_key' => 'vk_client_id',
                'type' => SiteSettings::SiteSettings_TypeString,
                'string_value' => 'xxx',
            ]);
            $setting->save(false);
        }

        $setting = SiteSettings::findOne(['text_key' => 'vk_client_secret']);
        if (!$setting) {
            $setting = new SiteSettings([
                'title' => 'Настройки компонентов авторизации VKontakte',
                'text_key' => 'vk_client_secret',
                'type' => SiteSettings::SiteSettings_TypeString,
                'string_value' => 'xxx',
            ]);
            $setting->save(false);
        }

        $setting = SiteSettings::findOne(['text_key' => 'facebook_client_id']);
        if (!$setting) {
            $setting = new SiteSettings([
                'title' => 'Настройки компонентов авторизации Facebook',
                'text_key' => 'facebook_client_id',
                'type' => SiteSettings::SiteSettings_TypeString,
                'string_value' => 'xxx',
            ]);
            $setting->save(false);
        }

        $setting = SiteSettings::findOne(['text_key' => 'facebook_client_secret']);
        if (!$setting) {
            $setting = new SiteSettings([
                'title' => 'Настройки компонентов авторизации Facebook',
                'text_key' => 'facebook_client_secret',
                'type' => SiteSettings::SiteSettings_TypeString,
                'string_value' => 'xxx',
            ]);
            $setting->save(false);
        }

        $setting = SiteSettings::findOne(['text_key' => 'twitter_consumer_key']);
        if (!$setting) {
            $setting = new SiteSettings([
                'title' => 'Настройки компонентов авторизации Twitter',
                'text_key' => 'twitter_consumer_key',
                'type' => SiteSettings::SiteSettings_TypeString,
                'string_value' => 'xxx',
            ]);
            $setting->save(false);
        }

        $setting = SiteSettings::findOne(['text_key' => 'twitter_consumer_secret']);
        if (!$setting) {
            $setting = new SiteSettings([
                'title' => 'Настройки компонентов авторизации Twitter',
                'text_key' => 'twitter_consumer_secret',
                'type' => SiteSettings::SiteSettings_TypeString,
                'string_value' => 'xxx',
            ]);
            $setting->save(false);
        }

        $setting = SiteSettings::findOne(['text_key' => 'ok_application_key']);
        if (!$setting) {
            $setting = new SiteSettings([
                'title' => 'Настройки компонентов авторизации Odnoklassniki',
                'text_key' => 'ok_application_key',
                'type' => SiteSettings::SiteSettings_TypeString,
                'string_value' => 'odnoklassniki_app_public_key',
            ]);
            $setting->save(false);
        }

        $setting = SiteSettings::findOne(['text_key' => 'ok_client_id']);
        if (!$setting) {
            $setting = new SiteSettings([
                'title' => 'Настройки компонентов авторизации Odnoklassniki',
                'text_key' => 'ok_client_id',
                'type' => SiteSettings::SiteSettings_TypeString,
                'string_value' => 'xxx',
            ]);
            $setting->save(false);
        }

        $setting = SiteSettings::findOne(['text_key' => 'ok_client_secret']);
        if (!$setting) {
            $setting = new SiteSettings([
                'title' => 'Настройки компонентов авторизации Odnoklassniki',
                'text_key' => 'ok_client_secret',
                'type' => SiteSettings::SiteSettings_TypeString,
                'string_value' => 'xxx',
            ]);
            $setting->save(false);
        }
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        echo "m171130_033527_create_social_settings cannot be reverted.\n";

        return true;
    }

}
