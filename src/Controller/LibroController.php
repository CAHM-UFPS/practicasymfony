<?php

namespace App\Controller;

use App\Entity\Libro;
use App\Form\LibroType;
use App\Repository\LibroRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/libro')]
class LibroController extends AbstractController
{
    #[Route('/create', name: 'create_book', methods: ['POST'])]
    public function create(Request $request, LibroRepository $bookRepository): JsonResponse
    {
        $book = new Libro();
        $form = $this->createForm(LibroType::class, $book);
        $form->submit($request->toArray());

        if ($form->isSubmitted() && $form->isValid()) {
            $bookRepository->add($book, true);
            return $this->json($book);
        }

        return $this->json($form->getErrors(true), 400);
    }

    #[Route('/list', name: 'list_books', methods: ['GET'])]
    public function read(LibroRepository $bookRepository): JsonResponse
    {
        return $this->json($bookRepository->findAll());
    }

    #[Route('/{id}', name: 'listBookById', methods: ['GET'])]
    public function readById(Libro $book = null): JsonResponse
    {
        if (!$book) {
            return $this->json(['message' => 'book not found'], 404);
        }

        return $this->json($book);
    }

    #[Route('/edit/{id}', name: 'edit_book', methods: ['PUT'])]
    public function update(Libro $book = null, Request $request, LibroRepository $bookRepository): JsonResponse
    {
        if (!$book) {
            return $this->json(['message' => 'book not found'], 404);
        }

        $form = $this->createForm(LibroType::class, $book);
        $form->submit($request->toArray());

        if ($form->isSubmitted() && $form->isValid())
        {
            $bookRepository->add($book, true);
            return $this->json($book, 201);
        }

        return $this->json($form->getErrors(true), 400);
    }

    #[Route('/{id}', name: 'delete_book', methods: ['DELETE'])]
    public function delete(Libro $book = null, LibroRepository $libroRepository)
    {
        if(!$book)
        {
            return $this->json(['message' => 'book not found'], 404);
        }

        $libroRepository->remove($book, true);

        return $this->json(['message'=>'successfully deleted book']);
    }
}
