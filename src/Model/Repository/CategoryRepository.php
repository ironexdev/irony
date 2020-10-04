<?php

namespace App\Model\Repository;

use App\Model\Entity\Category;
use Doctrine\ORM\NonUniqueResultException;
use Error;

class CategoryRepository extends AbstractRepository
{
    const ENTITY = Category::class;

    /**
     * @param \App\Model\Entity\Category|null $parent
     * @return \App\Model\Entity\Category
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(Category $parent = null): Category
    {
        $category = new Category($parent);

        $this->entityManagerService->persist($category);

        return $category;
    }

    /**
     * @param string $title
     * @return Category|null
     */
    public function findByTitle(string $title): ?Category
    {
        $query = $this->entityManagerService->createQuery("SELECT c FROM " . static::ENTITY . " c INNER JOIN c.translatableContent tc WHERE tc.title = :title");
        $query->setParameter("title", $title);

        try
        {
            return $query->getOneOrNullResult();
        }
        catch (NonUniqueResultException $e)
        {
            throw new Error($e->getMessage(), 0, $e);
        }
    }
}