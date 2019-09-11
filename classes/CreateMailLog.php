<?php namespace SureSoftware\MailLog\Classes;

use Illuminate\Mail\Message;
use October\Rain\Mail\Mailer;
use SureSoftware\MailLog\Models\MailLog;
use Swift_Attachment;

class CreateMailLog
{
    /**
     * @param Mailer  $mailer
     * @param string  $view
     * @param Message $message
     *
     * @return \Illuminate\Database\Eloquent\Model|MailLog
     */
    public function handle($mailer, $view, Message $message)
    {
        $mail = $message->getSwiftMessage();

        $attachments = collect($mail->getChildren())->filter(function ($item) {
            return $item instanceof Swift_Attachment;
        })->map(function (Swift_Attachment $attachment) {
            return [
                'name' => $attachment->getFilename(),
            ];
        });

        return MailLog::create([
            'to'          => $this->formatEmails($mail->getTo()),
            'cc'          => $this->formatEmails($mail->getCc()),
            'bcc'         => $this->formatEmails($mail->getBcc()),
            'from'        => $this->formatEmails($mail->getFrom()),
            'subject'     => $mail->getSubject(),
            'body'        => $mail->getBody(),
            'template'    => $view,
            'sent'        => true,
            'attachments' => $attachments,
        ]);
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
}
