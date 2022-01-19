<?php

namespace App\Controller;

use App\Entity\Crud;
use App\Form\CrudType; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class MainController extends AbstractController
{
    #[Route('/', name: 'main')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(Request $request, EntityManagerInterface $em)
    {
      $crud = new Crud();
      $form = $this->createForm(CrudType::class, $crud);
      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid()){
        //   $em = $this->getDoctrine()->getManager();
//          $em = $this->getDoctrine()->getManager();
          $em->persist($crud);
          $em->flush();

          $this->addFlash('notice', 'Sambmitted Successfully!!');

          return $this->redirectToRoute('main');
      }
      return $this->render('main/create.html.twig', [
          'form' => $form->createView(),
      ]);
    }


}
