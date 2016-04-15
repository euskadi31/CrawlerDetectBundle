<?php
/*
 * This file is part of the CrawlerDetectBundle package.
 *
 * (c) Axel Etcheverry <axel@etcheverry.biz>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Euskadi31\Bundle\CrawlerDetectBundle\Service;

use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Symfony\Component\HttpFoundation\Request;

/**
 * Crawler Detect Service
 */
class CrawlerDetectService extends CrawlerDetect
{
    /**
     * Construct CrawlerDetect with Request
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct(null, $request->headers->get('User-Agent'));
    }
}
