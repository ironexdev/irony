<?php

namespace App\Model\Fixture;

use App\Model\Entity\Category;
use App\Model\Entity\CategoryContent;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixture extends AbstractFixture
{
    /**
     * @param \Doctrine\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $categories = [
            [
                "parent" => false,
                "translations" => [
                    "cs" => "Počítače",
                    "en" => "Computers"
                ]
            ],
            [
                "parent" => true,
                "translations" => [
                    "cs" => "Stolní Počítače",
                    "en" => "Desktop Computers"
                ]
            ],
            [
                "parent" => true,
                "translations" => [
                    "cs" => "Herní Stolní Počítače",
                    "en" => "Desktop Gaming Computers"
                ]
            ],
            [
                "parent" => true,
                "translations" => [
                    "cs" => "Herní Stolní Počítače s OS",
                    "en" => "Desktop Gaming Computers with OS"
                ]
            ],
            [
                "parent" => true,
                "translations" => [
                    "cs" => "Herní Stolní Počítače a OS a NBD Podporou",
                    "en" => "Desktop Gaming Computers with OS and NBD Support"
                ]
            ],
            [
                "parent" => false,
                "translations" => [
                    "cs" => "Mobilní Telefony",
                    "en" => "Mobile Phones"
                ]
            ],
            [
                "parent" => true,
                "translations" => [
                    "cs" => "Chytré Mobilní Telefony",
                    "en" => "Smart Mobile Phones"
                ]
            ],
            [
                "parent" => false,
                "translations" => [
                    "cs" => "Monitory",
                    "en" => "Monitors"
                ]
            ],
            [
                "parent" => true,
                "translations" => [
                    "cs" => "Herní Monitory",
                    "en" => "Gaming Monitors"
                ]
            ],
            [
                "parent" => false,
                "translations" => [
                    "cs" => "Josticky",
                    "en" => "Joysticks"
                ]
            ]
        ];

        $parentCategory = null;
        foreach($categories as $category => $categoryData)
        {
            $parentCategory = $this->createCategory($categoryData["translations"], $parentCategory, $manager);
        }

        $manager->flush();
    }

    /**
     * @param array $translations
     * @param \App\Model\Entity\Category|null $parentCategory
     * @param \Doctrine\Persistence\ObjectManager $manager
     * @return \App\Model\Entity\Category
     */
    private function createCategory(array $translations, ?Category $parentCategory, ObjectManager $manager): Category
    {
        $category = new Category();

        if($parentCategory)
        {
            $category->setParent($parentCategory);
        }

        $manager->persist($category);

        foreach($translations as $language => $translation)
        {
            $categoryContent = new CategoryContent();
            $categoryContent->setTitle($translation);
            $categoryContent->setLanguage($language);
            $categoryContent->setCategory($category);
            $manager->persist($categoryContent);
        }

        return $category;
    }
}