<?php

namespace App\Controller\Dashboard;

use App\Entity\Payments;
use App\Form\PaymentsType;
use App\Repository\PaymentsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/payments")
 */
class PaymentsController extends BaseController
{
    /**
     * @Route("/", name="dashboard_payments_index", methods={"GET"})
     */
    public function index(PaymentsRepository $paymentsRepository): Response
    {
        return $this->render('dashboard/payments/index.html.twig', [
            'payments' => $paymentsRepository->findAll(), 'user'=>$this->user
        ]);
    }

    /**
     * @Route("/new", name="dashboard_payment_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $payment = new Payments();
        $form = $this->createForm(PaymentsType::class, $payment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($payment);
            $entityManager->flush();

            return $this->redirectToRoute('payments_index');
        }

        return $this->render('dashboard/payments/new.html.twig', [
            'payment' => $payment,
            'form' => $form->createView(),
            'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}", name="dashboard_payment_show", methods={"GET"})
     */
    public function show(Payments $payment): Response
    {
        return $this->render('dashboard/payments/show.html.twig', [
            'payment' => $payment, 'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}/edit", name="dashboard_payments_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Payments $payment): Response
    {
        $form = $this->createForm(PaymentsType::class, $payment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('payments_index', [
                'id' => $payment->getId(),
            ]);
        }

        return $this->render('dashboard/payments/edit.html.twig', [
            'payment' => $payment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dashboard_payment_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Payments $payment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$payment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($payment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('payments_index');
    }
}
