<?php

namespace App\Controller;

use App\Entity\Enrollment;
use App\Form\EnrollmentType;
use App\Repository\EnrollmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/enrollment')]
final class EnrollmentController extends AbstractController{
    #[Route(name: 'app_enrollment_index', methods: ['GET'])]
    public function index(Request $request, EntityManagerInterface $em, PaginatorInterface $paginator): Response
    {
        $queryBuilder = $em->getRepository(Enrollment::class)->createQueryBuilder('e')
            ->leftJoin('e.student', 's')
            ->leftJoin('e.course', 'c');

        if ($request->query->get('student')) {
            $queryBuilder->andWhere('s.name LIKE :student')
                ->setParameter('student', '%' . $request->query->get('student') . '%');
        }

        if ($request->query->get('course')) {
            $queryBuilder->andWhere('c.name LIKE :course')
                ->setParameter('course', '%' . $request->query->get('course') . '%');
        }

        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            $request->query->getInt('itemsPerPage', 10)
        );

        return $this->render('enrollment/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    #[Route('/new', name: 'app_enrollment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $enrollment = new Enrollment();
        $form = $this->createForm(EnrollmentType::class, $enrollment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($enrollment);
            $entityManager->flush();

            return $this->redirectToRoute('app_enrollment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('enrollment/new.html.twig', [
            'enrollment' => $enrollment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_enrollment_show', methods: ['GET'])]
    public function show(Enrollment $enrollment): Response
    {
        return $this->render('enrollment/show.html.twig', [
            'enrollment' => $enrollment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_enrollment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Enrollment $enrollment, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EnrollmentType::class, $enrollment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_enrollment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('enrollment/edit.html.twig', [
            'enrollment' => $enrollment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_enrollment_delete', methods: ['POST'])]
    public function delete(Request $request, Enrollment $enrollment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$enrollment->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($enrollment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_enrollment_index', [], Response::HTTP_SEE_OTHER);
    }
}
