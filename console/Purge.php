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
        $days = Settings::get('purge', 30);
        if ($this->argument('days')) {
            $days = (int) $this->argument('days');
        }

        MailLog::whereDate('created_at', '<=', now()->subDays($days))
            ->delete();

        $this->info('Purged all mail logs older than ' . $days . ' days');
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['days', InputArgument::OPTIONAL, 'How old the mail has to be for it to be purged. Default = 30'],
        ];
    }
}
