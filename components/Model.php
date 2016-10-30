<?php

namespace humanized\mail\components;

use Yii;

/**
 * Password reset request form
 */
class Model extends \yii\base\Model
{

    public $subject;
    public $from = [];
    public $to;
    public $path;
    public $extraParams = [];

    public function send()
    {
        if (!$this->beforeSend()) {
            return false;
        }
        if (Yii::$app->mailer
                        ->compose(
                                ['html' => $this->path . '-html', 'text' => $this->path . '-text'], $this->extraParams
                        )
                        ->setFrom($this->from)
                        ->setTo($this->to)
                        ->setSubject($this->subject)
                        ->send()) {
            return $this->afterSend();
        }
        return false;
    }

    protected function beforeSend()
    {
        if (empty($this->from)) {
            $this->from = [Yii::$app->params['no-reply'] => Yii::$app->name];
        }
        return true;
    }

    protected function afterSend()
    {
        return true;
    }

}
