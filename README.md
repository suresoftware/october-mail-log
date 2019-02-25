# OctoberCMS Mail Log

This plugin provides a backend log for all the outgoing mail sent by the website. It tracks the addresses to, from,
subject, template and timestamp of the email that was sent. This is useful for debugging email sending issues and 
auditing if mail was sent or not. Only mail that was successfully sent is tracked currently.

### Documentation

There is no configuration for this plugin, simply install it and it will start running. It has currently been tested 
with both the log and SMTP drivers. Please open an issue on the 
[GitHub Repository](https://github.com/suresoftware/october-mail-log) if you run into any other issues.

### Future Features
If demand exists, other features that can be added are:
 - Statistics on sending
 - Tracking of failed emails that haven't sent 
 - Notify an admin if an email has failed to send (via other channels like Slack)
 - More detailed logging
 - Options for configuring what fields to log