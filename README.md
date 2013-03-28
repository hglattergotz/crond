# Crond

Simple library for managing small crontab files in /etc/cron.d.

## Installation

Using Composer:

```json
{
    "require": {
        "hglattergotz/crond": "*"
    }
}
```

## Usage
```php
<?php
use HGG\Crond\Job;
use HGG\Crond\Crond;

$job = new Job();
$job->setUser('root');
$job->setCmd('/path/to/do/something/awesome');
$job->setTime('0 * * * *');
$job->setFileName('myCronJob');

$cron = new Crond();
$cron->install($job);
```

The above will install the cron job

    0 * * * * root /path/to/do/something/awesome

in a file located at

    /etc/cron.d/myCronJob

