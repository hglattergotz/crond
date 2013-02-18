<?php

/*
 * This file is part of the HGG package.
 *
 * (c) 2013 Henning Glatter-Götz <henning@glatter-gotz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HGG\Crond\Test;

use HGG\Crond\Crond;

class CrondTest extends \PHPUnit_Framework_TestCase
{
  protected function setUp()
  {
      $this->dir = sys_get_temp_dir().'/crond_tests_'.rand(11111, 99999);
      mkdir($this->dir);
      $this->crond = new Crond($this->dir);
  }

  protected function tearDown()
  {
      array_map('unlink', glob($this->dir.'/*'));
      rmdir($this->dir);
  }

  public function testCrond()
  {
      $cmd = 'the cmd';
      $fileName = 'crond_test';

      $job = $this->getMock('HGG\\Crond\\Job');
      $job->expects($this->once())
          ->method('getCronTabContent')
          ->will($this->returnValue($cmd));
      $job->expects($this->once())
          ->method('getFileName')
          ->will($this->returnValue($fileName));

      $this->crond->install($job);

      $this->assertFileExists($this->dir.'/'.$fileName);
      $this->assertEquals($cmd, file_get_contents($this->dir.'/'.$fileName));
  }
}
