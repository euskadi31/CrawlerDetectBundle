<?php
/*
 * This file is part of the CrawlerDetectBundle package.
 *
 * (c) Axel Etcheverry <axel@etcheverry.biz>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Euskadi31\Bundle\CrawlerDetectBundle\Tests\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Euskadi31\Bundle\CrawlerDetectBundle\DependencyInjection\Euskadi31CrawlerDetectExtension;

class Euskadi31CrawlerDetectExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Euskadi31CrawlerDetectExtension
     */
    protected $extension;

    /**
     * @var ContainerBuilder
     */
    protected $container;

    /**
     *
     */
    protected function initContainer()
    {
        $_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)';

        $this->extension = new Euskadi31CrawlerDetectExtension();
        $this->container = new ContainerBuilder();
        $this->container->register('event_dispatcher', new EventDispatcher());
        $this->container->register('request', new Request([], [], [], [], [], $_SERVER));
        $this->container->registerExtension($this->extension);
        $this->container->setParameter('kernel.debug', true);
    }

    /**
     * @param ContainerBuilder $container
     * @param $resource
     */
    protected function loadConfiguration(ContainerBuilder $container, $resource)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../_files/'));
        $loader->load($resource . '.yml');
    }

    public function testConfig()
    {
        $this->initContainer();
        $this->loadConfiguration($this->container, 'config');

        $this->container->compile();

        $this->assertTrue($this->container->has('crawler.detect'));

        $crawler = $this->container->get('crawler.detect');
        $this->assertInstanceOf('\Jaybizzle\CrawlerDetect\CrawlerDetect', $crawler);
        $this->assertInstanceOf('\Euskadi31\Bundle\CrawlerDetectBundle\Service\CrawlerDetectService', $crawler);

        $this->assertTrue($crawler->isCrawler());
    }
}
