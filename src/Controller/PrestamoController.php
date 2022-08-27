<?php

namespace App\Controller;

use App\Document\Prestamo;
use App\Entity\Libro;
use App\Entity\Usuario;
use App\Form\PrestamoType;
use Doctrine\ODM\MongoDB\DocumentManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/prestamo')]
class PrestamoController extends AbstractController
{
    #[Route('/create/{correo}/libro/{isbn}', name: 'createLoan', methods: ['POST'])]
    #[Entity('Libro', expr: 'repository.findByOne(isbn)')]
    public function create(Usuario $user = null, Libro $book = null, Request $request, DocumentManager $loanManager) : JsonResponse
    {
        $loan=new Prestamo();

        if(!$user || !$book)
        {
            return $this->json(['message'=>'user or book not exist'], 404);
        }

        $loan->setUserId($user->getId());
        $loan->setBookId($book->getId());
        $form=$this->createForm(PrestamoType::class, $loan);
        $form->submit($request->toArray());

        if($form->isSubmitted() && $form->isValid())
        {
            $loanManager->persist($loan); //Preparamos la consulta
            $loanManager->flush(); //Ejecutamos la consulta

            return $this->json($loan, 200);
        }

        return $this->json($form->getErrors(true), 400);
    }

    #[Route('/list', name: 'list_loans', methods: ['GET'])]
    public function read(DocumentManager $loanManager) : JsonResponse
    {
        return $this->json($loanManager->getRepository(Prestamo::class)->findAll());
    }

    #[Route('/list/{correo}', name: 'listByUser', methods: ['GET'])]
    public function readByUser(Usuario $user = null, DocumentManager $loanManager)
    {
        if(!$user)
        {
            return $this->json(['message'=>'user has not loan books'], 404);
        }

        return $this->json([
            'fullname'=> $user->getFullName(),
            'orders'=> $loanManager->getRepository(Prestamo::class)->findBy(['userId'=>$user->getId()])
        ]);
    }

    public function update()
    {

    }

    public function delete()
    {

    }
}
