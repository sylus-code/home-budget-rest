<?php


namespace App\Controller\Payment;


use App\Entity\Payment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AddController
{
    private $em;
    private $denormalizer;

    public function __construct(EntityManagerInterface $em, SerializerInterface $denormalizer)
    {
        $this->em = $em;
        $this->denormalizer = $denormalizer;
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

        /** @var Payment $payment */
        $payment->setUserId(1);
        $this->em->persist($payment);
        $this->em->flush();

        return new JsonResponse([], JsonResponse::HTTP_CREATED);
    }
}