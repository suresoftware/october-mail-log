<?php namespace SureSoftware\Maillog\Console;

use Illuminate\Console\Command;
use SureSoftware\MailLog\Models\MailLog;
use SureSoftware\MailLog\Models\Settings;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class Purge extends Command
{
    protected $name = 'maillog:purge';
    protected $description = 'Purge the maillog';

    public function handle()
    {
        MailLog::whereDate(
            'created_at', '<=', now()->subDays(Settings::get('purge', 180))
        )->delete();

        $this->info('Maillog purged');
    }
}
