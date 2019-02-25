<?php namespace SureSoftware\MailLog\Models;

use Model;

/**
 * Model
 */
class MailLog extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'suresoftware_maillog_log';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];
}
