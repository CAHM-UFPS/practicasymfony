<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\UsuarioType;
use App\Repository\UsuarioRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/usuario')]
class UsuarioController extends AbstractController
{
    #[Route('/create', name: 'create_user', methods: ['POST'])]
    public function create(Request $request, UsuarioRepository $usuarioRepository): JsonResponse
    {
        $user = new Usuario(); //Instancio el objeto usuario
        $form = $this->createForm(UsuarioType::class, $user); //Creamos el formulario con la clase Type
        $form->submit($request->toArray()); //Enviamos data convirtiendo los datos del request en arreglo

        if ($form->isSubmitted() && $form->isValid()) { //Validamos los datos y si hemos enviado data
            $usuarioRepository->add($user, true); //Añadimos a la base de datos
            return $this->json($user); //Retornamos el usuario creado como json
        }

        return $this->json([], 400);
    }

    #[Route('/list', name: 'list_users', methods: ['GET'])]
    public function read(UsuarioRepository $usuarioRepository): JsonResponse
    {
        return $this->json($usuarioRepository->findAll());
    }

    #[Route('/{id}', name: 'listUserById', methods: ['GET'])]
    public function readById(Usuario $user = null): JsonResponse
    {
        if(!$user)
        {
            return $this->json(['message' => 'user not found'], 404);
        }

        return $this->json($user);
    }

    #[Route('/edit/{id}', name: 'edit_user', methods: ['PUT'])]
    public function update(Usuario $user = null, Request $request, UsuarioRepository $usuarioRepository): JsonResponse
    {
        if (!$user) {
            return $this->json(['message' => 'user not found'], 404);
        }

        $form = $this->createForm(UsuarioType::class, $user);
        $form->submit($request->toArray());

        if ($form->isSubmitted() && $form->isValid()) {
            $usuarioRepository->add($user, true);
            return $this->json($user);
        }

        return $this->json([], 400);
    }

    #[Route('/{id}', name: 'delete_user', methods: ['DELETE'])]
    public function delete(Usuario $user = null, UsuarioRepository $usuarioRepository): JsonResponse
    {
        if(!$user)
        {
            return $this->json(['message'=>'user not found'], 404);
        }

        $usuarioRepository->remove($user, true);

        return $this->json(['message'=>'successfully deleted user']);
    }
}
