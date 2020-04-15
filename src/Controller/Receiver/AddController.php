<?php

namespace App\Controller\Receiver;

use App\Entity\Receiver;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AddController extends AbstractController
{
    private $denormalizer;
    private $em;

    public  function __construct( EntityManagerInterface $entityManager, SerializerInterface $denormalizer )
    {
        $this->denormalizer = $denormalizer;
        $this->em = $entityManager;
    }
    /**
     * @Route(path="/api/me/receiver" , name="receiver_add", methods={"POST"})
     * @param Request
     * @return JsonResponse
     */
    public function action(Request $request): JsonResponse
    {
        $receiverData = json_decode($request->getContent(), true);
        $receiver = $this->denormalizer->denormalize($receiverData, Receiver::class);

        $this->em->persist($receiver);
        $this->em->flush();

        $response = new JsonResponse([], Response::HTTP_CREATED);
        $response->headers->set('Access-Control-Allow-Origin', '*');

        return $response;
    }
}
