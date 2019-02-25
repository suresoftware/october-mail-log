<?php namespace SureSoftware\MailLog\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use System\Classes\SettingsManager;

class MailLogs extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController'
    ];
    
    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = [
        'access_log'
    ];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.System', 'system', 'settings');
        SettingsManager::setContext('SureSoftware.MailLog', 'maillogs');
    }
}
