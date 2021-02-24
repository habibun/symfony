<?php

namespace App\Repository\SingleTable;

use App\Entity\SingleTable\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * Class EmployeeRepository.
 */
class EmployeeRepository extends ServiceEntityRepository
{
    /**
     * EmployeeRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    /**
     * @param int $id
     *
     * @return Employee|null
     *
     * @throws NonUniqueResultException
     */
    public function findOneById(int $id): ?Employee
    {
        return $this->createQueryBuilder('e')
            ->where('e.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param Employee $employee
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function insert(Employee $employee): void
    {
        $this->getEntityManager()->persist($employee);
        $this->getEntityManager()->flush();
    }
}
