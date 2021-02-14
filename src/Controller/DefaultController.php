<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class DefaultController extends AbstractController
{
    /**
     * @Route(
     *     "/{_locale}/default",
     *     name="contact",
     * )
     *
     * @param TranslatorInterface $translator
     * @return Response
     */
    public function contact(TranslatorInterface $translator)
    {
        $translated = $translator->trans('Symfony is great');

        return $this->render('default/index.html.twig', ['message' => $translated]);
    }
}
