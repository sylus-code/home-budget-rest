<?php


namespace App\Controller\Transaction;


use App\Repository\TransactionRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;


class GetListController
{
    /** @var Serializer $normalizer */
    private $normalizer;
    private $transactionRepository;

    public function __construct( TransactionRepository $transactionRepository, SerializerInterface $normalizer)
    {
        $this->transactionRepository = $transactionRepository;
        $this->normalizer = $normalizer;
    }

    /**
     * @Route( path="/api/transaction", name="transaction_get_list", methods={"GET"})
     * @return JsonResponse
     * @throws
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

        return new JsonResponse($this->normalizer->normalize($transactions, "array", ["groups" => "transaction_get_list"]));
    }
}