<?php


namespace App\Controller\Payment;


use App\Repository\PaymentRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GetListController
{
    private $paymentRepository;
    private $serializer;

    public function __construct( PaymentRepository $paymentRepository, SerializerInterface $serializer )
    {
        $this->paymentRepository = $paymentRepository;
        $this->serializer = $serializer;
    }

    /**
     * @Route( path="/api/me/payment", name="payment_get_list", methods={"GET"})
     * @return JsonResponse
     */
    public function action(): JsonResponse
    {
        $payments = $this
            ->paymentRepository
            ->findAll();

        if (!$payments){

            return new JsonResponse([], JsonResponse::HTTP_NOT_FOUND);
        }
        return new JsonResponse($this->serializer->normalize($payments));
    }
}