<?php

namespace App\Model\Fixture;

use App\Enum\LanguageEnum;
use App\Model\Entity\Language;
use App\Model\Entity\Product;
use App\Model\Entity\ProductAttribute;
use App\Model\Entity\ProductAttributeTextTranslatableContent;
use App\Model\Repository\LanguageRepository;
use App\Model\Repository\ProductAttributeBoolFactory;
use App\Model\Repository\ProductAttributeDecimalFactory;
use App\Model\Repository\ProductAttributeFactory;
use App\Model\Repository\ProductAttributeIntFactory;
use App\Model\Repository\ProductAttributeRepository;
use App\Model\Repository\ProductAttributeTextFactory;
use App\Model\Repository\ProductAttributeTextTranslatableContentFactory;
use App\Model\Repository\ProductFactory;
use App\Model\Repository\ProductRepository;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductAttributeValueFixture extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * @var LanguageRepository
     */
    private $languageRepository;

    /**
     * @var ProductFactory
     */
    private $productFactory;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var ProductAttributeFactory
     */
    private $productAttributeFactory;

    /**
     * @var ProductAttributeRepository
     */
    private $productAttributeRepository;
    
    /**
     * @var ProductAttributeBoolFactory
     */
    private $productAttributeBoolFactory;

    /**
     * @var ProductAttributeDecimalFactory
     */
    private $productAttributeDecimalFactory;

    /**
     * @var ProductAttributeIntFactory
     */
    private $productAttributeIntFactory;

    /**
     * @var ProductAttributeTextFactory
     */
    private $productAttributeTextFactory;

    /**
     * @var ProductAttributeTextTranslatableContentFactory
     */
    private $productAttributeTextTranslatableContentFactory;

    /**
     * ProductAttributeTextFixture constructor.
     * @param \App\Model\Repository\LanguageRepository $languageRepository
     * @param \App\Model\Repository\ProductRepository $productRepository
     * @param \App\Model\Repository\ProductFactory $productFactory
     * @param \App\Model\Repository\ProductAttributeRepository $productAttributeRepository
     * @param \App\Model\Repository\ProductAttributeFactory $productAttributeFactory
     * @param \App\Model\Repository\ProductAttributeBoolFactory $productAttributeBoolFactory
     * @param \App\Model\Repository\ProductAttributeDecimalFactory $productAttributeDecimalFactory
     * @param \App\Model\Repository\ProductAttributeIntFactory $productAttributeIntFactory
     * @param \App\Model\Repository\ProductAttributeTextFactory $productAttributeTextFactory
     * @param \App\Model\Repository\ProductAttributeTextTranslatableContentFactory $productAttributeTextTranslatableContentFactory
     */
    public function __construct(LanguageRepository $languageRepository, ProductRepository $productRepository, ProductFactory $productFactory, ProductAttributeRepository $productAttributeRepository, ProductAttributeFactory $productAttributeFactory, ProductAttributeBoolFactory $productAttributeBoolFactory, ProductAttributeDecimalFactory $productAttributeDecimalFactory, ProductAttributeIntFactory $productAttributeIntFactory, ProductAttributeTextFactory $productAttributeTextFactory, ProductAttributeTextTranslatableContentFactory $productAttributeTextTranslatableContentFactory)
    {
        $this->languageRepository = $languageRepository;
        $this->productFactory = $productFactory;
        $this->productRepository = $productRepository;
        $this->productAttributeFactory = $productAttributeFactory;
        $this->productAttributeRepository = $productAttributeRepository;
        $this->productAttributeBoolFactory = $productAttributeBoolFactory;
        $this->productAttributeDecimalFactory = $productAttributeDecimalFactory;
        $this->productAttributeIntFactory = $productAttributeIntFactory;
        $this->productAttributeTextFactory = $productAttributeTextFactory;
        $this->productAttributeTextTranslatableContentFactory = $productAttributeTextTranslatableContentFactory;
    }

    /**
     * @param \Doctrine\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        /** @var Language $enLanguage */
        $enLanguage = $this->languageRepository->findOneBy(["iso2" => LanguageEnum::EN]);
        /** @var Language $csLanguage */
        $csLanguage = $this->languageRepository->findOneBy(["iso2" => LanguageEnum::CS]);
        /** @var Product[] $products */
        $products = $this->productRepository->findAll();
        /** @var ProductAttribute[] $productAttributes */
        $productAttributes = $this->productAttributeRepository->findAll();

        $i = 0;
        foreach ($products as $product)
        {
            $pointer = $i % 2;
            $productAttributeCount = 50;
            $max = $productAttributeCount / (($pointer) + 1);
            $min = $pointer ? 0 : $max / 2;
            for($ii = $min; $ii < $max; $ii++)
            {
                /** @var \App\Model\Entity\ProductAttribute $productAttribute */
                $productAttribute = $productAttributes[$ii];

                $type = $productAttribute->getType();

                if($type === "text")
                {
                    $enValue = "Value " . $enLanguage->getIso2() . " - " . $i . " - " . $ii;
                    $csValue = "Value " . $csLanguage->getIso2() . " - " . $i . " - " . $ii;

                    $productAttributeValue = $this->productAttributeTextFactory->create($enValue, $product, $productAttribute, $enLanguage);
                    $productAttributeValue->addTranslatableContent($this->productAttributeTextTranslatableContentFactory->create($csValue, $productAttributeValue, $csLanguage));
                }
                else if($type === "boolean")
                {
                    $productAttributeValue = $this->productAttributeBoolFactory->create((bool) $pointer, $product, $productAttribute);
                }
                else if($type === "decimal")
                {
                    $productAttributeValue = $this->productAttributeDecimalFactory->create((float) $i, $product, $productAttribute);
                }
                else // int
                {
                    $productAttributeValue = $this->productAttributeIntFactory->create($i, $product, $productAttribute);
                }

                $manager->persist($productAttributeValue);
            }

            $i++;

            if($i % 100 === 0)
            {
                echo "Values for " . $i . " product/s created.\n";
            }
        }

        $manager->flush();
        $manager->clear();

        echo static::class . " done.";
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            LanguageFixture::class,
            ProductFixture::class,
            ProductAttributeFixture::class
        ];
    }
}