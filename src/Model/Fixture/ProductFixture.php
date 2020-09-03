<?php

namespace App\Model\Fixture;

use App\Model\Entity\Product;
use App\Model\Entity\ProductContent;
use App\Model\Repository\CategoryRepository;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixture extends AbstractFixture
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * ProductFixture constructor.
     * @param \App\Model\Repository\CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param \Doctrine\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $categories = $this->categoryRepository->findAll();

        for ($i = 0; $i < 100; $i++)
        {
            $product = new Product();
            $product->setPrice(mt_rand(100, 10000));
            $product->setCategory($categories[mt_rand(0, count($categories) - 1)]);
            $manager->persist($product);

            $productContent = new ProductContent();
            $productContent->setTitle("EN Product Title " . $i);
            $productContent->setSummary("EN Product Summary " . $i);
            $productContent->setDescription("EN Product Description " . $i);
            $productContent->setLanguage("en");
            $productContent->setProduct($product);
            $manager->persist($productContent);

            $productContent = new ProductContent();
            $productContent->setTitle("CS Product Title " . $i);
            $productContent->setSummary("CS Product Summary " . $i);
            $productContent->setDescription("CS Product Description " . $i);
            $productContent->setLanguage("cs");
            $productContent->setProduct($product);
            $manager->persist($productContent);
        }

        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            CategoryFixture::class,
        ];
    }
}