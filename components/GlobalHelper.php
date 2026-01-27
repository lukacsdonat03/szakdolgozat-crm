<?php

namespace app\components;

use Yii;
use yii\base\Component;

class GlobalHelper extends Component
{

    /**
     * A paraméterként kapott változót adja vissza
     * és megszakítja a kódot
     * @param $var mixed változó vagy string
     * @return void
     */
    public static function debug($var){
        header('Content-type: text/plain; charset=utf-8');
        print_r($var);
        exit();
    }

    public static function getValueFromArray($array, $key){
        return (!empty($array[$key]))?$array[$key]:'';
    }

    /**
     * Sends an email using the configured Yii mailer component.
     *
     * @param string|array $to Desitnation email address or array of addresses.
     * @param string $subject The subject of the email.
     * @param string $body The plain text body of the email.
     * @param string|null $htmlBody Optional HTML version of the email body.
     *
     * @return bool Whether the email was sent successfully.
     *
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\mail\MailException
     */
    public static function sendMail($to, string $subject, string $body, ?string $htmlBody = null){
        $message = Yii::$app->mailer->compose();

        $message->setFrom($_ENV['GMAIL_EMAIL'])
            ->setTo($to)
            ->setSubject($subject)
            ->setTextBody($body);

        if ($htmlBody !== null) {
            $message->setHtmlBody($htmlBody);
        }

        return $message->send();
    }

    /**
     * Árformázás
     * @param $price float Ár
     * @param $decimals int Tizedesjegyek
     * @param $after string Valuta jel előtag
     * @param $before string Valuta jel utótag
     * @return string
     */
    public static function priceFormat($price, $decimals = 0, $after = 'Ft', $before = ''){
          if($price == '') {
            return '';
        }

        $beforeT = (!empty($before))? '<span class="currency before">' .$before. '</span>' : '';
        $afterT = (!empty($after))? '<span class="currency after">' .$after. '</span>': '';

        return $beforeT.number_format($price, $decimals, '.', ' ').' '.$afterT;
    }

    public static function isMenuOpened($module){
        return (Yii::$app->controller->module->id == $module);
    }

    public static function getModuleId(){
        return Yii::$app->controller->module->id;
    }
}