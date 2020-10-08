<?php

namespace App\Model\Fixture;

use App\Enum\LanguageEnum;
use App\Model\Entity\Language;
use App\Model\Entity\Product;
use App\Model\Entity\ProductAttribute;
use App\Model\Entity\ProductAttributeTextTranslatableContent;
use App\Model\Repository\LanguageRepository;
use App\Model\Repository\ProductAttributeBoolRepository;
use App\Model\Repository\ProductAttributeDecimalRepository;
use App\Model\Repository\ProductAttributeIntRepository;
use App\Model\Repository\ProductAttributeRepository;
use App\Model\Repository\ProductAttributeTextRepository;
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
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var ProductAttributeRepository
     */
    private $productAttributeRepository;
    /**
     * @var ProductAttributeBoolRepository
     */
    private $productAttributeBoolRepository;

    /**
     * @var ProductAttributeDecimalRepository
     */
    private $productAttributeDecimalRepository;

    /**
     * @var ProductAttributeIntRepository
     */
    private $productAttributeIntRepository;

    /**
     * @var ProductAttributeTextRepository
     */
    private $productAttributeTextRepository;

    /**
     * ProductAttributeTextFixture constructor.
     * @param \App\Model\Repository\LanguageRepository $languageRepository
     * @param \App\Model\Repository\ProductRepository $productRepository
     * @param \App\Model\Repository\ProductAttributeRepository $productAttributeRepository
     * @param \App\Model\Repository\ProductAttributeBoolRepository $productAttributeBoolRepository
     * @param \App\Model\Repository\ProductAttributeDecimalRepository $productAttributeDecimalRepository
     * @param \App\Model\Repository\ProductAttributeIntRepository $productAttributeIntRepository
     * @param \App\Model\Repository\ProductAttributeTextRepository $productAttributeTextRepository
     */
    public function __construct(LanguageRepository $languageRepository, ProductRepository $productRepository, ProductAttributeRepository $productAttributeRepository, ProductAttributeBoolRepository $productAttributeBoolRepository, ProductAttributeDecimalRepository $productAttributeDecimalRepository, ProductAttributeIntRepository $productAttributeIntRepository, ProductAttributeTextRepository $productAttributeTextRepository)
    {
        $this->languageRepository = $languageRepository;
        $this->productRepository = $productRepository;
        $this->productAttributeRepository = $productAttributeRepository;
        $this->productAttributeBoolRepository = $productAttributeBoolRepository;
        $this->productAttributeDecimalRepository = $productAttributeDecimalRepository;
        $this->productAttributeIntRepository = $productAttributeIntRepository;
        $this->productAttributeTextRepository = $productAttributeTextRepository;
    }

    /**
     * @param \Doctrine\Persistence\ObjectManager $manager
     * @throws \Doctrine\ORM\ORMException
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

                    $productAttributeValue = $this->productAttributeTextRepository->create($enValue, $product, $productAttribute, $enLanguage);
                    $productAttributeValue->addTranslatableContent(new ProductAttributeTextTranslatableContent($csValue, $productAttributeValue, $csLanguage));
                }
                else if($type === "boolean")
                {
                    $this->productAttributeBoolRepository->create((bool) $pointer, $product, $productAttribute);
                }
                else if($type === "decimal")
                {
                    $this->productAttributeDecimalRepository->create((float) $i, $product, $productAttribute);
                }
                else if($type === "int")
                {
                    $this->productAttributeIntRepository->create($i, $product, $productAttribute);
                }
            }

            $i++;

            if($i % 100 === 0)
            {
                echo "Values for " . $i . " product/s created.\n";
            }
        }

        $manager->flush();

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