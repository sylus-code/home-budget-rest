<?php

namespace App\Controller\Transaction;

use App\Entity\Transaction;
use App\Service\PersistWithUserIdWrapper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AddController
{
    private $denormalizer;
    private $persistWrapper;

    public function __construct(
        SerializerInterface $denormalizer,
        PersistWithUserIdWrapper $persistWrapper
    ) {
        $this->denormalizer = $denormalizer;
        $this->persistWrapper = $persistWrapper;
    }

    /**
     * @Route( path="/api/me/transaction", name="transaction_add", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function action(Request $request) :JsonResponse
    {
        $transactionData = json_decode($request->getContent(), true);
        $transaction = $this->denormalizer->denormalize($transactionData, Transaction::class);
        $this->persistWrapper->save($transaction);

        $response = new JsonResponse([], JsonResponse::HTTP_CREATED);
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }
}