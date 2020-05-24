<?php namespace SureSoftware\MailLog;

use Backend\Facades\Backend;
use Illuminate\Support\Facades\Event;
use SureSoftware\Maillog\Console\Purge;
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
        Event::listen('mailer.send', function ($mailer, $view, \Illuminate\Mail\Message $message) {
            try {
                (new MailLog)->createFromMailerSendEvent($mailer, $view, $message);
            } catch (\Exception $e) {
                // Loggers should never trigger exceptions
            }
        });
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => "Mail Log Settings",
                'description' => 'Mail Log purge command settings',
                'category'    => SettingsManager::CATEGORY_LOGS,
                'icon'        => 'icon-cog',
                'class'       => Models\Settings::class,
                'order'       => 901,
                'keywords'    => 'mail log purge',
                'permissions' => ['system.access_logs'],
            ],
            'mailLog'  => [
                'label'       => 'Mail Log',
                'description' => 'View all outgoing mail with their outgoing timestamps and email addresses',
                'category'    => SettingsManager::CATEGORY_LOGS,
                'icon'        => 'icon-envelope-o',
                'url'         => Backend::url('suresoftware/maillog/maillogs'),
                'order'       => 900,
                'keywords'    => 'mail log',
                'permissions' => ['system.access_logs'],
            ],

        ];
    }

    public function register()
    {
        $this->registerConsoleCommand('maillog:purge', Purge::class);
    }

    public function registerSchedule($schedule)
    {
        $schedule->command(Purge::class)->daily();
    }
}
