<?php namespace SureSoftware\MailLog\Controllers;

use Backend;
use Backend\Classes\Controller;
use BackendMenu;
use Redirect;
use System\Classes\SettingsManager;

class MailLogs extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'access_log',
    ];

    /**
     * @var string HTML body tag class
     */
    public $bodyClass = 'compact-container';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.System', 'system', 'settings');
        SettingsManager::setContext('SureSoftware.MailLog', 'mailLog');
    }

    public function index_onRefresh()
    {
        return $this->listRefresh();
    }

    public function create($context = null)
    {
        return Redirect::to(Backend::url('suresoftware/maillog/maillogs'));
    }

    public function update($context = null)
    {
        return Redirect::to(Backend::url('suresoftware/maillog/maillogs'));
    }
}
