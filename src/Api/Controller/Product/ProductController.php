<?php

namespace App\Api\Controller\Product;

use App\Api\Controller\AbstractController;
use App\Api\Exception\Http\NotFoundException;
use App\Api\Response\Response;

class ProductController extends AbstractController
{
    /**
     * @param int $id
     * @return \App\Api\Response\Response
     * @throws \App\Api\Exception\Http\NotFoundException
     */
    public function read(int $id): Response
    {
        if($id)
        {
            $product = $id === 1 ? ["title" => "Product 1", "description" => "This is the description of Product 1."] : null;

            if($product)
            {
                return $this->response((object) $product);
            }
            else
            {
                throw new NotFoundException();
            }
        }

        $searchCriteria = $this->request->getQuery();

        $category = $searchCriteria["category"] ?? null;

        if($category)
        {
            if($category === "Category 1")
            {
                return $this->response((object) []);
            }
            else
            {
                throw new NotFoundException();
            }
        }

        throw new NotFoundException();
    }
}