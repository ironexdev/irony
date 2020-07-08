<?php

namespace App\Model\Repository;

use App\Model\Service\EntityManagerService;
use Doctrine\ORM\EntityRepository;

abstract class AbstractRepository extends EntityRepository
{
    const ENTITY = "";

    /**
     * @var EntityManagerService
     */
    protected $entityManagerService;

    /**
     * AbstractRepository constructor.
     * @param \App\Model\Service\EntityManagerService $entityManagerService
     */
    public function __construct(EntityManagerService $entityManagerService)
    {
        $this->entityManagerService = $entityManagerService;

        parent::__construct($entityManagerService, $entityManagerService->getClassMetadata(static::ENTITY));
    }
}