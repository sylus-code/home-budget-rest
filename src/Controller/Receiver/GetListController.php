<?php
/**
 * Created by PhpStorm.
 * User: sylwiajakubiak
 * Date: 06/04/2020
 * Time: 12:10
 */

namespace App\Controller\Receiver;


use App\Repository\ReceiverRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class GetListController
{
    private $receiverRepository;
    /** @var Serializer $normalizer */
    private $normalizer;

    public function __construct( ReceiverRepository $receiverRepository, SerializerInterface $normalizer)
    {
        $this->receiverRepository = $receiverRepository;
        $this->normalizer = $normalizer;
    }

    /**
     * @Route( path="/api/me/receiver" , name="receiver_get_list", methods={"GET"})
     * @return JsonResponse
     * @throws
     */
    public function action():JsonResponse
    {
        $receivers = $this
            ->receiverRepository
            ->findAll();

        if (!$receivers) {
            return new JsonResponse([], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse($this->normalizer->normalize($receivers, "array", ["groups"=>"receiver_get_list"]));
    }
}
