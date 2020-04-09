<?php


namespace App\Controller\Transaction;


use App\Repository\PaymentRepository;
use App\Repository\TransactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EditController
{
    private $transactionRepository;
    private $paymentRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        TransactionRepository $transactionRepository,
        PaymentRepository $paymentRepository
    ) {
        $this->em = $entityManager;
        $this->transactionRepository = $transactionRepository;
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * @param $request
     * @param $id
     * @Route( path="/api/transaction/{id}", name="transaction_edit", methods={"PUT"})
     * @return JsonResponse
     */
    public function action(Request $request, int $id): JsonResponse
    {
        $transaction = $this
            ->transactionRepository
            ->find($id);

        // sprawdz czy jest w gole jest taka transakcja, jak nie ma to zwroc 404
        if ($transaction->getId() === null){
            return new JsonResponse([], JsonResponse::HTTP_NOT_FOUND);
        }

        // get data from request and
        $transactionData = json_decode($request->getContent(), true);

        // dodac walidacje, ale to pozniej

        $updated = false;
        // check what changed and add it to object
        if (isset($transactionData['amount'])) {
            $transaction->setAmount($transactionData['amount']);
            $updated = true;
        }
        if (isset($transactionData['date'])) {
            $date = new \DateTime($transactionData['date']);
            $transaction->setDate($date);
            $updated = true;
        }
        if (isset($transactionData['name'])) {
            $transaction->setName($transactionData['name']);
            $updated = true;
        }
        if (isset($transactionData['type'])) {
            $transaction->setType($transactionData['type']);
            $updated = true;
        }
        if (isset($transactionData['status'])) {
            $transaction->setStatus($transactionData['status']);
        }
        if (isset($transactionData['paymentId'])) {
            $payment = $this->paymentRepository->find($transactionData['paymentId']);
            if ($payment === null){
                return new JsonResponse([], JsonResponse::HTTP_NOT_FOUND);
            }
            $transaction->setPayment($payment);
            $updated = true;
        }

        // save updated object to db
        if ($updated){
            $this->em->persist($transaction);
            $this->em->flush();

        }

        return new JsonResponse();
    }
}