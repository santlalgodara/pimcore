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

use App\Website\LinkGenerator\NewsLinkGenerator;
use App\Website\Navigation\BreadcrumbHelperService;
use Knp\Component\Pager\PaginatorInterface;
use Pimcore\Model\DataObject\Product;
use Pimcore\Twig\Extension\Templating\HeadTitle;
use Pimcore\Twig\Extension\Templating\Placeholder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends BaseController
{
    public function productsAction(Request $request, PaginatorInterface $paginator){
        $items = new Product\Listing();
        // $items->setOrderKey('key');
        // $items->setOrder('DESC');


        $paginator = $paginator->paginate(
            $items,
            $request->get('page', 1),
            2
        );

        return $this->render('products/items.html.twig', [
            'items' => $paginator,
            'paginationVariables' => $paginator->getPaginationData()
        ]);
    }
    public function productAction(){
        $blogList = new Product\Listing();
        $blogList->setOrderKey('title');
        $blogList->setOrder('DESC');
        return $this->render('products/item.html.twig', [
            'posts' => $blogList,
        ]);
    }

}
