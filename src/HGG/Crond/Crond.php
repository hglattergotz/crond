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
     * @var string
     * @access protected
     */
    protected $cronPath;

    public function __construct($cronPath = '/etc/cron.d')
    {
        $this->cronPath = $cronPath;
    }

    /**
     * getCronPath
     *
     * @access public
     * @return string
     */
    public function getCronPath()
    {
        return $this->cronPath;
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
     * Check if a HGG\Crond\Job instance is installed.
     *
     * @param mixed $job
     * @access public
     * @return boolean
     */
    public function isInstalled($job)
    {
        return $this->isInstalledFName($job->getFileName());
    }

    /**
     * isInstalledFName
     *
     * Check if a cron job is installed by using the file name passed as a
     * paramter.
     * This is usually a bit handier than first having to construct an instance
     * of HGG\Crond\Job.
     *
     * @param string $fileName The file name the cron job is stored in
     * @access public
     * @return boolean
     */
    public function isInstalledFName($fileName)
    {
        if (null == $fileName || '' == $fileName) {
            throw new \InvalidArgumentException('The file name is not set!');
        }

        return file_exists($this->cronPath.'/'.$fileName);
    }

    /**
     * uninstall
     *
     * @param HGG\Crond\Job $job
     * @param boolean $throwException
     * @access public
     * @return boolean
     */
    public function uninstall($job, $throwException = true)
    {
        return $this->uninstallFName($job->getFileName(), $throwException);
    }

    /**
     * uninstallFName
     *
     * @param mixed $fileName
     * @param bool $throwException
     * @access public
     * @return void
     */
    public function uninstallFName($fileName, $throwException = true)
    {
        if (false == $this->isInstalledFName($fileName)) {
            if ($throwException) {
                throw new \Exception('A cron job with the file name '.
                    $fileName.' is not installed!');
            } else {
                return false;
            }
        }

        return unlink($this->cronPath.'/'.$fileName);
   }
}
