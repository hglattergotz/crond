<?php
/*
 * This file is part of the HGG package.
 *
 * (c) 2013 Henning Glatter-Götz <henning@glatter-gotz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HGG\Crond;

use HGG\Crond\Job;

/**
 * Manage small named crontab files in /etc/cron.d
 *
 * @author Henning Glatter-Götz <henning@glatter-gotz.com>
 */
class Crond
{
    /**
     * cronPath
     *
     * @var mixed
     * @access protected
     */
    protected $cronPath;

    public function __construct($cronPath = '/etc/cron.d')
    {
        $this->cronPath = $cronPath;
    }

    /**
     * install
     *
     * @param mixed $job
     * @access public
     * @return void
     */
    public function install($job)
    {
        $cronTabContent = $job->getCrontabContent();
        $fullPath = $this->cronPath.'/'.$job->getFileName();

        if (false === @file_put_contents($fullPath, $cronTabContent)) {
            throw new \RuntimeException('Unable to write file '.$fullPath);
        }

        if (false === @chmod($fullPath, 0644, true)) {
            throw new \RuntimeException('Unable to chmod 0644 on '.$fullPath);
        }

        return true;
    }

    /**
     * isInstalled
     *
     * @param mixed $job
     * @access public
     * @return void
     */
    public function isInstalled($job)
    {
        $fileName = $job->getFileName();

        if (null == $fileName) {
            throw new \InvalidArgumentException('The file name is not set!');
        }

        return file_exists($this->cronPath.'/'.$fileName);
    }

    /**
     * uninstall
     *
     * @param mixed $job
     * @access public
     * @return void
     */
    public function uninstall($job)
    {
        if (false == $this->isInstalled($job)) {
            throw new \Exception('A cron job with the file name '.
                $job->getFileName().' is not installed!');
        }

        $fileName = $job->getFileName();

        return unlink($this->cronPath.'/'.$fileName);
    }
}
