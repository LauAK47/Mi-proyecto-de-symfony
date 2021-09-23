<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Form\CategoriaType;
use App\Repository\CategoriaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categoria')]
class CategoriaController extends AbstractController
{
    #[Route('/', name: 'categoria_index', methods: ['GET'])]
    public function index(CategoriaRepository $categoriaRepository): Response
    {
        return $this->render('categoria/index.html.twig', [
            'categorias' => $categoriaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'categoria_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $categorium = new Categoria();
        $form = $this->createForm(CategoriaType::class, $categorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorium);
            $entityManager->flush();

            return $this->redirectToRoute('categoria_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categoria/new.html.twig', [
            'categorium' => $categorium,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'categoria_show', methods: ['GET'])]
    public function show(Categoria $categorium): Response
    {
        return $this->render('categoria/show.html.twig', [
            'categorium' => $categorium,
        ]);
    }

    #[Route('/{id}/edit', name: 'categoria_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Categoria $categorium): Response
    {
        $form = $this->createForm(CategoriaType::class, $categorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categoria_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categoria/edit.html.twig', [
            'categorium' => $categorium,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'categoria_delete', methods: ['POST'])]
    public function delete(Request $request, Categoria $categorium): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorium->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categorium);
            $entityManager->flush();
        }

        return $this->redirectToRoute('categoria_index', [], Response::HTTP_SEE_OTHER);
    }
}
