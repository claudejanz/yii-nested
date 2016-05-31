<?php

namespace app\models;

use app\extentions\helpers\EuroDateTime;
use app\models\base\MailBase;
use app\models\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\Html;

class Mail extends MailBase
{

    /**
     * @inheritdoc
     */
    public function behaviors()
        {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
            ],
        ];
        }

    public function prepareWeekReport($week) {
        if ($week->reportings) {
            foreach ($week->reportings as $key => $reporting) {
                /* @var $reporting Reporting */
                if ($reporting->feedback) {
                    $this->content .= Html::beginTag('p');
                    $this->content .= Html::tag('b', Yii::$app->formatter->asDate($reporting->day->date)) . Html::tag('br');
                    $this->content .= $reporting->feedback;
                    $this->content .= Html::endTag('p');
                }
            }
        }
    }

    public function sendWeekReport($user) {
        /* @var $user User */
        $date = new EuroDateTime($this->date);
        $title = $this->subject;
        $old_transport = Yii::$app->mailer->transport;
        Yii::$app->mailer->transport = [
            'class'    => 'Swift_SmtpTransport',
            'host'     => !empty($user->trainer->mail_host) ? $user->trainer->mail_host : 'mail.infomaniak.ch',
            'username' => $user->trainer->email,
            'password' => $user->trainer->mail_password,
            'port'     => !empty($user->trainer->mail_port) ? $user->trainer->mail_port : '587',
                //'encryption' => 'tls',
        ];
        if (Yii::$app->mailer->compose('simpleMail', ['model' => $this, 'user' => $user])
                        ->setFrom([$user->trainer->email => $user->trainer->fullname])
                        ->setTo($user->email)
                        ->setSubject($title)
                        ->send()) {
            $this->sender_id = $user->trainer_id;
            $this->save();
        } else {
            Yii::$app->mailer->transport = $old_transport;
            if (Yii::$app->mailer->compose('simpleMail', ['model' => $this, 'user' => $user])
                            ->setFrom([Yii::$app->params['mailerEmail'] => Yii::$app->params['mailerName']])
                            ->setTo($user->email)
                            ->setSubject($title)
                            ->send()) {
                return true;
            }

            return false;
        }
    }

}
