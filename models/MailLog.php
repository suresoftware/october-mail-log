<?php namespace SureSoftware\MailLog\Models;

use Illuminate\Mail\Message;
use Model;
use October\Rain\Mail\Mailer;
use Swift_Attachment;
use Swift_Message;

/**
 * Model
 */
class MailLog extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'suresoftware_maillog_log';

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    /**
     * @var array Attribute names to encode and decode using JSON.
     */
    protected $jsonable = ['attachments'];

    protected $hiddenWhenEmpty = [
        'attachments',
        'cc',
        'bcc',
    ];

    /**
     * @param Mailer  $mailer
     * @param string  $view
     * @param Message $message
     *
     * @return $this
     */
    public function createFromMailerSendEvent($mailer, $view, Message $message)
    {
        $mail = $message->getSwiftMessage();

        $this->fill([
            'to'          => $this->formatEmails($mail->getTo()),
            'cc'          => $this->formatEmails($mail->getCc()),
            'bcc'         => $this->formatEmails($mail->getBcc()),
            'from'        => $this->formatEmails($mail->getFrom()),
            'subject'     => $mail->getSubject(),
            'body'        => $mail->getBody(),
            'template'    => $view,
            'sent'        => true,
            'attachments' => $this->extractAttachments($mail),
        ])->save();

        return $this;
    }

    public function getAttachmentsCountAttribute()
    {
        if ($this->attachments === null || $this->attachments === 0) {
                return 0;
        } else {
                return count($this->attachments);
        }
    }

    public function filterFields($fields, $context = null)
    {
        foreach ($this->hiddenWhenEmpty as $field) {
            if (empty($fields->{$field}->value)) {
                $fields->{$field}->hidden = true;
            }
        }
    }

    /**
     * @param $contacts
     *
     * @return string|void
     */
    private function formatEmails($contacts)
    {
        if (is_array($contacts)) {
            return implode(", ", array_keys((array)$contacts));
        }
    }

    /**
     * @param Swift_Message $mail
     *
     * @return \October\Rain\Support\Collection
     */
    private function extractAttachments(Swift_Message $mail)
    {
        return collect($mail->getChildren())->filter(function ($item) {
            return $item instanceof Swift_Attachment;
        })->map(function (Swift_Attachment $attachment) {
            return [
                'name' => $attachment->getFilename(),
            ];
        });
    }
}
