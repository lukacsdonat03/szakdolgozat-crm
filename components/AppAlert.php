<?php

namespace app\components;

use Yii;
use kartik\alert\Alert;

class AppAlert extends Alert
{
    /**
     * AppAlert::addAlert([
     *   'type' => AppAlert::TYPE_DANGER,
     *   'title' => Yii::t('website','Hiba!'),
     *   'icon' => AppAlert::ICON_ALERT,
     *   'body' => Yii::t('website','Hibás adatok!'),
     *   'closeButton' => false,
     *   'showSeparator' => true,
     *   'delay' => 3000
     * ]);
     */

    const ICON_INFO = "fa-solid fa-circle-info";
    const ICON_ALERT = "fa-solid fa-circle-exclamation";

    /**
     * Új alert felvétele
     * @param $data array alert adatai
     * @return void
     */
    public static function addAlert($data)
    {
        Yii::$app->session->setFlash('appalert', $data);
    }

    /**
     * Új hiba alert felvétele
     * @param $message string üzenet
     * @return void
     */
    public static function addErrorAlert($message)
    {
        AppAlert::addAlert([
            'type' => AppAlert::TYPE_DANGER,
            'icon' => AppAlert::ICON_ALERT,
            'body' => $message,
            'closeButton' => false,
            'showSeparator' => false,
            'delay' => 3000
        ]);
    }

    /**
     * Új sikeres alert felvétele
     * @param $message string üzenet
     * @return void
     */
    public static function addSuccessAlert($message)
    {
        AppAlert::addAlert([
            'type' => AppAlert::TYPE_SUCCESS,
            'icon' => AppAlert::ICON_INFO,
            'body' => $message,
            'closeButton' => false,
            'showSeparator' => false,
            'delay' => 3000
        ]);
    }

    /**
     * Alert megjelenítése
     * @return string
     * @throws \Throwable
     */
    public static function showAlert()
    {
        if(Yii::$app->session->hasFlash('appalert')) {
            return Alert::widget(Yii::$app->session->getFlash('appalert'));
        }

        return false;
    }
}