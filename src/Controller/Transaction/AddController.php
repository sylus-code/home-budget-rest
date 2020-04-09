<?php


namespace App\Controller\Transaction;


use App\Entity\Transaction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AddController
{
    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $denormalizer )
    {
        $this->denormalizer = $denormalizer;
        $this->em = $entityManager;
    }

    /**
     * @Route( path="/api/transaction", name="transaction_add", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function action(Request $request) :JsonResponse
    {
        $transactionData = json_decode($request->getContent(), true);
        /** @var Transaction $transaction */
        $transaction = $this->denormalizer->denormalize($transactionData, Transaction::class);
        $transaction->setUserId(1);
        $this->em->persist($transaction);
        $this->em->flush();

        return new JsonResponse([], JsonResponse::HTTP_CREATED);
    }
}