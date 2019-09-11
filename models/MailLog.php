<?php namespace SureSoftware\MailLog\Models;

use Model;

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

    public function getAttachmentsCountAttribute()
    {
        return count($this->attachments);
    }

    public function filterFields($fields, $context = null)
    {
        foreach ($this->hiddenWhenEmpty as $field) {
            if (empty($fields->{$field}->value)) {
                $fields->{$field}->hidden = true;
            }
        }
    }
}
