# OctoberCMS Mail Log

This plugin provides a backend log for all the outgoing mail sent by the website. It tracks the addresses to, from,
subject, template and timestamp of the email that was sent. This is useful for debugging email sending issues and 
auditing if mail was sent or not. Only mail that was successfully sent is tracked currently.

Logs by default are only retained for 30 days.

## Documentation

Simply install it and it will start running. It has currently been tested with both the log and SMTP drivers. Please open an issue on the 
[GitHub Repository](https://github.com/suresoftware/october-mail-log) if you run into any other issues.

### Configuration

You can change the number of days the log will be retained for in the "Mail Log Settings" area. The default is 30 days.

### Commands

`php artisan mailog:purge 30` Purge all mail logs after x number of days. Default is 30

## Possible Future Features
If you want any of these features, please request it on Github or open a PR
 - Statistics on sending
 - Tracking of failed emails that haven't sent 
 - Notify an admin if an email has failed to send (via other channels like Slack)
 - More detailed logging
 - Options for configuring which fields to log