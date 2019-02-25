<?php namespace SureSoftware\MailLog;

use Backend\Facades\Backend;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use October\Rain\Mail\Mailer;
use SureSoftware\MailLog\Models\MailLog;
use System\Classes\PluginBase;
use System\Classes\SettingsManager;

class Plugin extends PluginBase
{
    /**
     * Boot method, called right before the request route.
     *
     */
    public function boot()
    {
        Event::listen('mailer.send', function ($mailer, $view,\Illuminate\Mail\Message $message) {
            $mail = $message->getSwiftMessage();
            MailLog::create([
                "to" => $this->getEmails($mail->getTo()),
                "from" => $this->getEmails($mail->getFrom()),
                "subject" => $mail->getSubject(),
                "template" => $view,
                "sent" => true
            ]);
        });
    }

    public function registerSettings()
    {
        return [
            'mailLog' => [
                'label'       => 'Mail Log',
                'description' => 'View all outgoing mail with their outgoing timestamps and email addresses',
                'category'    => SettingsManager::CATEGORY_LOGS,
                'icon'        => 'icon-envelope-o',
                'url'       => Backend::url('suresoftware/maillog/maillogs'),
                'order'       => 900,
                'keywords'    => 'mail log',
                'permissions' => ['system.access_logs']
            ],
        ];
    }

    private function getEmails(array $contacts){
        return implode (", ", array_keys($contacts));
    }
}
