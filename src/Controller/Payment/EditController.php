<?php


namespace App\Controller\Payment;


use App\Repository\PaymentRepository;
use App\Repository\ReceiverRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EditController
{
    private $paymentRepository;
    private $receiverRepository;
    private $em;

    public function __construct(
        PaymentRepository $paymentRepository, EntityManagerInterface $em, ReceiverRepository $receiverRepository
    ){
        $this->paymentRepository = $paymentRepository;
        $this->em = $em;
        $this->receiverRepository = $receiverRepository;
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @Route(path="/api/me/payment/{id}", name="payment_edit", methods={"PUT"})
     */
    public function action(Request $request, int $id)
    {
        $payment = $this
            ->paymentRepository
            ->find($id);
        if ($payment->getId() === null){
            return new JsonResponse([], JsonResponse::HTTP_NOT_FOUND);
        }

        $paymentData = json_decode($request->getContent(), true);
        $updated = false;

        if (isset($paymentData['startDate'])){
            $payment->setStartDate($paymentData['startDate']);
            $updated = true;
        }
        if (isset($paymentData['frequency'])){
            $payment->setFrequency($paymentData['frequency']);
            $updated = true;
        }
        if (isset($paymentData['amount'])){
            $payment->setAmount($paymentData['amount']);
            $updated = true;
        }
        if (isset($paymentData['type'])){
            $payment->setType($paymentData['type']);
            $updated = true;
        }
        if (isset($paymentData['dueDay'])){
            $payment->setDueDay($paymentData['dueDay']);
            $updated = true;
        }
        if (isset($paymentData['name'])){
            $payment->setName($paymentData['name']);
            $updated = true;
        }
        if (isset($paymentData['note'])){
            $payment->setNote($paymentData['note']);
            $updated = true;
        }
        if (isset($paymentData['expiryDate'])){
            $payment->setExpiryDate($paymentData['expiryDate']);
            $updated = true;
        }
        if (isset($paymentData['bankAccountNumber'])){
            $payment->setBankAccountNumber($paymentData['bankAccountNumber']);
            $updated = true;
        }
        if (isset($paymentData['receiverId'])){
            $receiver = $this->receiverRepository->find($paymentData['receiverId']);
            if ($receiver === null){
                return new JsonResponse([], JsonResponse::HTTP_NOT_FOUND);
            }
            $payment->setReciever($receiver);
            $updated = true;
        }

        if ($updated){
            $this->em->persist($payment);
            $this->em->flush();
        }

        return new JsonResponse();
    }
}