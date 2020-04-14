<?php

namespace App\Controller\Payment;

use App\Entity\Payment;
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
     * @param Request $request
     * @Route(path="/api/me/payment", name="payment_add", methods={"POST"})
     * @return JsonResponse
     */
    public function action(Request $request): JsonResponse
    {
        $paymentData = json_decode($request->getContent(), true);
        $payment = $this->denormalizer->denormalize($paymentData, Payment::class);
        $this->persistWrapper->save($payment);

        return new JsonResponse([], JsonResponse::HTTP_CREATED);
    }
}