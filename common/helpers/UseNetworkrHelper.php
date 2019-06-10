<?php

namespace common\helpers;


use common\models\User\UserNetwork;
use yii\helpers\Html;

class UseNetworkrHelper
{
    public static function getNetworkLink(UserNetwork $network, $showIcon = false): string
    {
        switch ($network->network) {
            case 'vkontakte':
                $url = 'https://vk.com/id' . $network->identity;
                $name = isset($network->info['first_name'], $network->info['last_name']) ? $network->info['first_name'] . ' ' . $network->info['last_name'] : 'VKontakte';
                break;
            case 'facebook':
                $url = 'https://www.facebook.com/profile.php?id=' . $network->identity;
                $name = $network->info['name'] ?? 'Facebook';
                break;
            case 'yandex':
                $url = 'https://passport.yandex.ru/profile';
                $name = $network->info['display_name'] ?? 'Yandex';
                break;
            case 'odnoklassniki':
                $url = 'https://ok.ru/profile/' . $network->identity;
                $name = isset($network->info['first_name'], $network->info['last_name']) ? $network->info['first_name'] . ' ' . $network->info['last_name'] : 'Odnoklassniki';
                break;
            case 'mailru':
                $url = 'https://mail.ru';
                $name = isset($network->info['first_name'], $network->info['last_name']) ? $network->info['first_name'] . ' ' . $network->info['last_name'] : 'Mail.ru';
                break;
            case 'google':
                $url = $network->info['link'] ?? 'https://plus.google.com/' . ($network->info['id'] ?? '');
                $name = $network->info['name'] ?? 'Google';
                break;
            default: return '';
        }

        $icon = $showIcon ? '<span class="social-icon ' . $network->network . '"></span>' : '';
        return Html::a($icon . $name, $url, ['target' => '_blank']);
    }
}