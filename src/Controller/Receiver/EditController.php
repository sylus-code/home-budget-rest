<?php


namespace App\Controller\Receiver;


use App\Repository\ReceiverRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EditController
{
    private $receiverRepository;
    private $em;

    public function __construct( ReceiverRepository $receiverRepository, EntityManagerInterface $em )
    {
        $this->receiverRepository = $receiverRepository;
        $this->em = $em;
    }

    /**
     * @param Request $request
     * @param int $id
     * @Route( path="/api/receiver/{id}", name="receiver_edit", methods={"PUT"})
     * @return JsonResponse
     */
    public function action(Request $request, int $id): JsonResponse
    {
        $receiver = $this
            ->receiverRepository
            ->find($id);

        if ($receiver->getId() === null){
            return new JsonResponse([], JsonResponse::HTTP_NOT_FOUND);
        }

        $receiverData = json_decode($request->getContent(),true);
        $updated = false;

        if (isset($receiverData['name'])){
            $receiver->setName($receiverData['name']);
            $updated = true;
        }

        if ($updated){
            $this->em->persist($receiver);
            $this->em->flush();
        }

        return new JsonResponse();
    }
}