<?php namespace SureSoftware\MailLog\Updates;

use Illuminate\Support\Facades\Mail;
use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateSuresoftwareMaillogLog extends Migration
{
    public function up()
    {
        Schema::create('suresoftware_maillog_log', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('to')->nullable();
            $table->string('from')->nullable();
            $table->string('subject')->nullable();
            $table->string('template')->nullable();
            $table->boolean('sent')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('suresoftware_maillog_log');
    }
}
