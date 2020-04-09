<?php


namespace App\Controller\Transaction;


use App\Repository\TransactionRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GetListController
{
    private $transactionRepository;
    private $serializer;

    public function __construct( TransactionRepository $transactionRepository, SerializerInterface $serializer)
    {
        $this->transactionRepository = $transactionRepository;
        $this->serializer = $serializer;
    }

    /**
     * @Route( path="/api/transaction", name="transaction_get_list", methods={"GET"})
     * @return JsonResponse
     */
    public function action(): JsonResponse
    {
        $transactions = $this
            ->transactionRepository
            ->findAll();

        if (!$transactions)
        {
            return new JsonResponse([], JsonResponse::HTTP_NOT_FOUND);
        }
        return new JsonResponse($this->serializer->normalize($transactions));
    }
}