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

/**
 * Job
 *
 * @author Henning Glatter-Götz <henning@glatter-gotz.com>
 */
class Job
{
    /**
     * user
     *
     * @var mixed
     * @access protected
     */
    protected $user;

    /**
     * cmd
     *
     * @var mixed
     * @access protected
     */
    protected $cmd;

    /**
     * time
     *
     * @var mixed
     * @access protected
     */
    protected $time;

    /**
     * fileName
     *
     * @var mixed
     * @access protected
     */
    protected $fileName;

    /**
     * __construct
     *
     * @param bool $user
     * @param bool $cmd
     * @param bool $time
     * @param bool $fileName
     * @access public
     * @return void
     */
    public function __construct($user = null, $cmd = null, $time = null, $fileName = null)
    {
      $this->user = $user;
      $this->cmd = $cmd;
      $this->time = $time;
      $this->fileName = $fileName;
    }

    /**
     * setUser
     *
     * @param mixed $user
     * @access public
     * @return void
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * getUser
     *
     * @access public
     * @return void
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * setCmd
     *
     * @param mixed $cmd
     * @access public
     * @return void
     */
    public function setCmd($cmd)
    {
        $this->cmd = $cmd;
    }

    /**
     * getCmd
     *
     * @access public
     * @return void
     */
    public function getCmd()
    {
        return $this->cmd;
    }

    /**
     * setTime
     *
     * @param mixed $cronTime
     * @access public
     * @return void
     */
    public function setTime($cronTime)
    {
        $this->time = $cronTime;
    }

    /**
     * getTime
     *
     * @access public
     * @return void
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * setFileName
     *
     * @param mixed $fileName
     * @access public
     * @return void
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * getFileName
     *
     * @access public
     * @return void
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * getCrontabContent
     *
     * @access public
     * @return void
     */
    public function getCrontabContent()
    {
        $this->validateTime($this->time);
        $this->validateUser($this->user);
        $this->validateCmd($this->cmd);
        $this->validateFileName($this->fileName);

        return sprintf("%s %s %s%s", $this->time, $this->user, $this->cmd, PHP_EOL);
    }

    /**
     * validateTime
     *
     * @param mixed $time
     * @access protected
     * @return void
     */
    protected function validateTime($time)
    {
        if (null == $time) {
            throw new InvalidArgumentException('Time not set!');
        }
    }

    /**
     * validateUser
     *
     * @param mixed $user
     * @access protected
     * @return void
     */
    protected function validateUser($user)
    {
        if (null == $user) {
            throw new InvalidArgumentException('User not set!');
        }
    }

    /**
     * validateCmd
     *
     * @param mixed $cmd
     * @access protected
     * @return void
     */
    protected function validateCmd($cmd)
    {
        if (null == $cmd) {
            throw new InvalidArgumentException('Cmd not set!');
        }
    }

    /**
     * validateFileName
     *
     * @param mixed $fileName
     * @access protected
     * @return void
     */
    protected function validateFileName($fileName)
    {
        if (null == $fileName) {
            throw new InvalidArgumentException('File name not set!');
        }
    }
}
