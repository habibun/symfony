<?php

namespace App\Controller\SingleTable;

use App\Entity\SingleTable\Accountant;
use App\Entity\SingleTable\Developer;
use App\Entity\SingleTable\Employee;
use App\Entity\SingleTable\Marketer;
use App\Repository\SingleTable\EmployeeRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/single")
 * Class DefaultController.
 */
class DefaultController
{
    /**
     * @var EmployeeRepository
     */
    private $employeeRepository;

    /**
     * DefaultController constructor.
     *
     * @param EmployeeRepository $employeeRepository
     */
    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * @Route("/{id}", methods={"GET"})
     *
     * @param int $id
     *
     * @return Response
     *
     * @throws NonUniqueResultException
     */
    public function getOneAction(int $id)
    {
        $employee = $this->employeeRepository->findOneById($id);
        if (!$employee instanceof Employee) {
            throw new BadRequestHttpException('Employee not found.');
        }

        return new Response(get_class($employee), Response::HTTP_OK);
    }

    /**
     * @Route("/accountants", methods={"POST"})
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createAccountantAction(Request $request)
    {
        $fields = json_decode($request->getContent(), true);

        $accountant = $this->createEmployee(new Accountant(), $fields);

        $this->employeeRepository->insert($accountant);

        return new Response(null, Response::HTTP_CREATED);
    }

    /**
     * @Route("/developers", methods={"POST"})
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createDeveloperAction(Request $request)
    {
        $fields = json_decode($request->getContent(), true);

        /** @var Developer $developer */
        $developer = $this->createEmployee(new Developer(), $fields);
        $developer->setCalibre($fields['calibre']);

        $this->employeeRepository->insert($developer);

        return new Response(null, Response::HTTP_CREATED);
    }

    /**
     * @Route("/marketers", methods={"POST"})
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createMarketerAction(Request $request)
    {
        $fields = json_decode($request->getContent(), true);

        /** @var Marketer $marketer */
        $marketer = $this->createEmployee(new Marketer(), $fields);
        $marketer->setIsInternal($fields['is_internal']);

        $this->employeeRepository->insert($marketer);

        return new Response(null, Response::HTTP_CREATED);
    }

    /**
     * @param Employee $employee
     * @param array    $fields
     *
     * @return Employee
     */
    private function createEmployee(Employee $employee, array $fields): Employee
    {
        $employee->setFirstname($fields['firstname']);
        $employee->setLastname($fields['lastname']);
        $employee->setLevel($fields['level']);

        return $employee;
    }
}
