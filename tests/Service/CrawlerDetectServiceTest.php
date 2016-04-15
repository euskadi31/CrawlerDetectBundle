<?php
/*
 * This file is part of the CrawlerDetectBundle package.
 *
 * (c) Axel Etcheverry <axel@etcheverry.biz>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Euskadi31\Bundle\CrawlerDetectBundle\Tests\Service;

use Euskadi31\Bundle\CrawlerDetectBundle\Service\CrawlerDetectService;

class CrawlerDetectServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testService()
    {
        $headerMock = $this->getMock('Symfony\Component\HttpFoundation\HeaderBag');

        $headerMock->expects($this->once())
            ->method('get')
            ->with($this->equalTo('User-Agent'))
            ->will($this->returnValue('Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'));

        $requestMock = $this->getMock('\Symfony\Component\HttpFoundation\Request');
        $requestMock->headers = $headerMock;

        $service = new CrawlerDetectService($requestMock);

        $this->assertTrue($service->isCrawler());
    }
}
