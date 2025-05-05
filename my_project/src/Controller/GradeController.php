<?php

namespace App\Controller;

use App\Entity\Grade;
use App\Form\GradeType;
use App\Repository\GradeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
#[IsGranted('ROLE_MANAGER')]
#[Route('/grade')]
final class GradeController extends AbstractController{
    #[IsGranted('ROLE_MANAGER')]
    #[Route(name: 'app_grade_index', methods: ['GET'])]
    public function index(Request $request, EntityManagerInterface $em, PaginatorInterface $paginator): Response
    {
        $queryBuilder = $em->getRepository(Grade::class)->createQueryBuilder('g')
            ->leftJoin('g.enrollment', 'e');

        if ($request->query->get('score')) {
            $queryBuilder->andWhere('g.score = :score')
                ->setParameter('score', $request->query->get('score'));
        }

        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            $request->query->getInt('itemsPerPage', 10)
        );

        return $this->render('grade/index.html.twig', [
            'pagination' => $pagination
        ]);
    }
    #[IsGranted('ROLE_MANAGER')]
    #[Route('/new', name: 'app_grade_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $grade = new Grade();
        $form = $this->createForm(GradeType::class, $grade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($grade);
            $entityManager->flush();

            return $this->redirectToRoute('app_grade_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('grade/new.html.twig', [
            'grade' => $grade,
            'form' => $form,
        ]);
    }
    #[IsGranted('ROLE_MANAGER')]
    #[Route('/{id}', name: 'app_grade_show', methods: ['GET'])]
    public function show(Grade $grade): Response
    {
        return $this->render('grade/show.html.twig', [
            'grade' => $grade,
        ]);
    }
    #[IsGranted('ROLE_MANAGER')]
    #[Route('/{id}/edit', name: 'app_grade_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Grade $grade, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GradeType::class, $grade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_grade_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('grade/edit.html.twig', [
            'grade' => $grade,
            'form' => $form,
        ]);
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_grade_delete', methods: ['POST'])]
    public function delete(Request $request, Grade $grade, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$grade->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($grade);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_grade_index', [], Response::HTTP_SEE_OTHER);
    }
}
