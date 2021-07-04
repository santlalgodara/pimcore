<?php

/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Enterprise License (PEL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PEL
 */

namespace App\Twig\Extension;

use App\Website\LinkGenerator\BlogLinkGenerator;
use Pimcore\Model\DataObject\Blog;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class BlogExtension extends AbstractExtension
{
    /**
     * @var BlogLinkGenerator
     */
    protected $blogLinkGenerator;

    /**
     * NewsExtension constructor.
     *
     * @param NewsLinkGenerator $blogLinkGenerator
     */
    public function __construct(BlogLinkGenerator $blogLinkGenerator)
    {
        $this->blogLinkGenerator = $blogLinkGenerator;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('app_blog_detaillink', [$this, 'generateLink']),
        ];
    }

    /**
     * @param News $blog
     *
     * @return string
     */
    public function generateLink(Blog $blog): string
    {
        return $this->blogLinkGenerator->generate($blog, []);
    }
}
