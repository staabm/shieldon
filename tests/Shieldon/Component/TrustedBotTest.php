<?php declare(strict_types=1);
/*
 * This file is part of the Shieldon package.
 *
 * (c) Terry L. <contact@terryl.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Shieldon\Component;


class TrustedBotTest extends \PHPUnit\Framework\TestCase
{
    public function testSetStrict()
    {
        $trustedBotComponent = new TrustedBot();
        $trustedBotComponent->setStrict(false);

        $reflection = new \ReflectionObject($trustedBotComponent);
        $t = $reflection->getProperty('strictMode');
        $t->setAccessible(true);
  
        $this->assertEquals('strictMode' , $t->name);
        $this->assertFalse($t->getValue($trustedBotComponent));
    }

    public function testSetDeniedList()
    {
        $this->assertFalse(false);
    }

    public function testSetDeniedItem()
    {
        $this->assertFalse(false);
    }

    public function testGetDeniedList()
    {
        $this->assertFalse(false);
    }

    public function testIsDenied()
    {
        $this->assertFalse(false);
    }

    public function testIsAllowed()
    {
        $trustedBotComponent = new TrustedBot();
        $result = $trustedBotComponent->isAllowed();
        $this->assertFalse($result);

        $_SERVER['HTTP_USER_AGENT'] = 'Googlebot/2.1 (+http://www.google.com/bot.html)';
        $trustedBotComponent = new TrustedBot();
        $trustedBotComponent->setIp('66.249.66.1', true);
        $result = $trustedBotComponent->isAllowed();
        $this->assertTrue($result);

        $trustedBotComponent->setStrict(true);
        $trustedBotComponent->setIp('101.12.19.1');
        $trustedBotComponent->setRdns('crawl-66-249-66-1.googlebot.com');
        $result = $trustedBotComponent->isAllowed();
        $this->assertFalse($result);

        $trustedBotComponent->setList([]);
        $result = $trustedBotComponent->isAllowed();
        $this->assertFalse($result);
    }

    public function testRemoveItem()
    {
        $trustedBotComponent = new TrustedBot();

        $trustedBotComponent->removeItem('.google.com');
        $list = $trustedBotComponent->getList();

        if (! in_array('.google.com', $list)) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }
    }

    public function testAddItem()
    {
        $trustedBotComponent = new TrustedBot();

        $trustedBotComponent->addItem('acer', 'acer-euro.com');
        $list = $trustedBotComponent->getList();

        if (in_array('.acer-euro.com', $list)) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }
    }

    public function testAddList()
    {
        $trustedBotComponent = new TrustedBot();
        $trustedBotComponent->addList([]);

        $reflection = new \ReflectionObject($trustedBotComponent);
        $t = $reflection->getProperty('trustedBotList');
        $t->setAccessible(true);
  
        $this->assertSame([] , $t->getValue($trustedBotComponent));
    }

    public function testIsGoogle()
    {
        $trustedBotComponent = new TrustedBot();
        $trustedBotComponent->setIp('66.249.66.1', true);

        if ($trustedBotComponent->isGoogle()) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }

        $trustedBotComponent->setRdns('UNKNOWN-8-12-144-X.yahoo.com');

        if (! $trustedBotComponent->isGoogle()) {
            $this->assertFalse(false);
        } else {
            $this->assertFalse(true);
        }
    }

    public function testIsYahoo()
    {
        $trustedBotComponent = new TrustedBot();
        $trustedBotComponent->setIp('8.12.144.1', true);
        if ($trustedBotComponent->isYahoo()) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }

        $trustedBotComponent->setRdns('msnbot-40-77-169-1.search.msn.com');

        if (! $trustedBotComponent->isYahoo()) {
            $this->assertFalse(false);
        } else {
            $this->assertFalse(true);
        }
    }

    public function testIsBing()
    {
        $trustedBotComponent = new TrustedBot();
        $trustedBotComponent->setIp('40.77.169.1', true);

        if ($trustedBotComponent->isBing()) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }

        $trustedBotComponent->setRdns('crawl-66-249-66-1.googlebot.com');

        if (! $trustedBotComponent->isBing()) {
            $this->assertFalse(false);
        } else {
            $this->assertFalse(true);
        }
    }
}
