<?php


namespace App\Controller\Payment;


use App\Repository\PaymentRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class GetListController
{
    private $paymentRepository;
    /** @var Serializer $normalizer  */
    private $normalizer;

    public function __construct( PaymentRepository $paymentRepository, SerializerInterface $normalizer )
    {
        $this->paymentRepository = $paymentRepository;
        $this->normalizer = $normalizer;
    }

    /**
     * @Route( path="/api/me/payment", name="payment_get_list", methods={"GET"})
     * @return JsonResponse
     * @throws
     */
    public function action(): JsonResponse
    {
        $payments = $this
            ->paymentRepository
            ->findAll();

        if (!$payments){

            return new JsonResponse([], JsonResponse::HTTP_NOT_FOUND);
        }
        return new JsonResponse($this->normalizer->normalize($payments,"array",["groups" => "payment_get_list"]));
    }
}