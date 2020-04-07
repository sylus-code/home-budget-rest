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
use Symfony\Component\Serializer\SerializerInterface;

class GetListController
{
    private $receiverRepository;
    private $serializer;

    public function __construct( ReceiverRepository $receiverRepository, SerializerInterface $serializer)
    {
        $this->receiverRepository = $receiverRepository;
        $this->serializer = $serializer;
    }

    /**
     * @Route( path="/api/me/receiver" , name="receiver_get_list", methods={"GET"})
     */
    public function action()
    {
        $receivers = $this
            ->receiverRepository
            ->findAll();

        if (!$receivers) {
            return new JsonResponse([], 404);
        }

        return new JsonResponse($this->serializer->normalize($receivers));
    }
}
