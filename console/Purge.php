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
        $dayToPurge = Settings::get('purge', 180);
        if ($this->argument('number_of_days')) {
            $dayToPurge = (int) $this->argument('number_of_days');
        }

        MailLog::whereDate(
            'created_at', '<=', now()->subDays($dayToPurge)
        )->delete();

        $this->info('Maillog purged');
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['number_of_days', InputArgument::OPTIONAL, 'Number of days to purge'],
        ];
    }
}
