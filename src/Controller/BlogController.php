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

namespace App\Controller;

use App\Website\LinkGenerator\BlogLinkGenerator;
use App\Website\Navigation\BreadcrumbHelperService;
use Knp\Component\Pager\PaginatorInterface;
use Pimcore\Model\DataObject\Blog;
use Pimcore\Twig\Extension\Templating\HeadTitle;
use Pimcore\Twig\Extension\Templating\Placeholder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends BaseController
{
    const BLOG_DEFAULT_DOCUMENT_PROPERTY_NAME = 'blog_default_document';
    // public function defaultAction()
    // {
    //     return [];
    // }
    public function postAction(){
        $blogList = new Blog\Listing();
        $blogList->setOrderKey('title');
        $blogList->setOrder('DESC');
        return $this->render('blog/posts.html.twig', [
            'posts' => $blogList,
        ]);
    }


    /**
     * @Route("{path}/{title}~n{blog}", name="blog-detail", defaults={"path"=""}, requirements={"path"=".*?", "title"="[\w-]+", "news"="\d+"})
     *
     * @param Request $request
     * @param HeadTitle $headTitleHelper
     * @param Placeholder $placeholderHelper
     * @param NewsLinkGenerator $newsLinkGenerator
     * @param BreadcrumbHelperService $breadcrumbHelperService
     *
     * @return Response
     */
    public function detailAction(Request $request, HeadTitle $headTitleHelper, Placeholder $placeholderHelper, BlogLinkGenerator $blogLinkGenerator, BreadcrumbHelperService $breadcrumbHelperService)
    {
        $blog = Blog::getById($request->get('blog'));

        if (!($blog instanceof Blog && ($blog->isPublished() || $this->verifyPreviewRequest($request, $blog)))) {
            throw new NotFoundHttpException('Blog not found.');
        }

        $headTitleHelper($blog->getTitle());
        // $breadcrumbHelperService->enrichNewsPage($post);

        $placeholderHelper('canonical')->set($blogLinkGenerator->generate($blog, ['document' => $this->document->getProperty(self::BLOG_DEFAULT_DOCUMENT_PROPERTY_NAME)]));

        return $this->render('blog/post.html.twig', [
            'post' => $blog
        ]);
    }


}
