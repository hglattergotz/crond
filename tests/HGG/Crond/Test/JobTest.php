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

use HGG\Crond\Job;

class JobTest extends \PHPUnit_Framework_TestCase
{
  public function testSetUser()
  {
    $user = 'root';
    $job = new Job();
    $job->setUser($user);

    $this->assertEquals($user, $job->getUser());
  }
}
