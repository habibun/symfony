<?php


namespace App\Presentation\Web\Backoffice\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route(name="dashboard", path="/")
     */
    public function index()
    {
        return $this->render('@Backoffice/dashboard/index.html.twig');
    }
}