<?php

namespace App\Api\Controller;

use App\Api\Response\Response;
use App\Model\Entity\Category;
use App\Model\Entity\CategoryTranslatableContent;
use App\Model\Entity\Language;
use App\Model\Entity\Product;
use App\Model\Entity\ProductCategoryRelation;
use App\Model\Repository\CategoryRepository;
use App\Model\Repository\CategoryTranslatableContentRepository;
use App\Model\Repository\LanguageRepository;
use App\Model\Repository\ProductCategoryRelationRepository;
use App\Model\Repository\ProductRepository;

class IndexController extends AbstractController
{
    /**
     * @param \App\Model\Repository\CategoryRepository $categoryRepository
     * @param \App\Model\Repository\CategoryTranslatableContentRepository $categoryTranslatableContentRepository
     * @param \App\Model\Repository\LanguageRepository $languageRepository
     * @param \App\Model\Repository\ProductRepository $productRepository
     * @param \App\Model\Repository\ProductCategoryRelationRepository $productCategoryRelationRepository
     * @return \App\Api\Response\Response
     */
    public function read(CategoryRepository $categoryRepository, CategoryTranslatableContentRepository $categoryTranslatableContentRepository, LanguageRepository $languageRepository, ProductRepository $productRepository, ProductCategoryRelationRepository $productCategoryRelationRepository): Response
    {
        $authenticated = $this->user->isLoggedIn();
        $userData = [
            "authenticated" => $authenticated,
            "role" => $this->user->getRole()
        ];

        if ($authenticated)
        {
            $userData["account"] = [
                "email" => $this->user->getAccount()
                                      ->getEmail(),
                "authenticationTokenExpiration" => $this->user->getAuthenticationToken()
                                                              ->getExpiration()
            ];
        }

        /** @var Product $product */
        $product = $productRepository->find("5d31eeff-02b4-11eb-a834-04d4c46fcb84");
        var_dump($product->removeCategory($productCategoryRelationRepository->findOneBy(["product" => $product, "category" => $categoryRepository->find("014a197b-02b0-11eb-a834-04d4c46fcb84")])));
        $this->entityManagerService->persist($product);
        $this->entityManagerService->flush();

        return $this->response((object) 200);
    }
}