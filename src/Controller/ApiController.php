<?php

namespace App\Controller;

use App\DataObject\CallObject;
use App\Repository\CallEntityRepository;
use App\Transformer\CallTransformer;
use App\Worker\EventWorker;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\DataArraySerializer;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class ApiController
 * @package App\Controller
 * @Route("/api", name="api_")
 */
class ApiController extends AbstractFOSRestController
{
    /** @var LoggerInterface */
    private $logger;

    /** @var EventWorker */
    private $eventWorker;

    /** @var CallEntityRepository */
    private $callRepository;

    public function __construct(
        LoggerInterface $logger,
        EventWorker $eventWorker,
        CallEntityRepository $callRepository
    ) {
        $this->logger = $logger;
        $this->eventWorker = $eventWorker;
        $this->callRepository = $callRepository;
    }

    /**
     * listening to nexmos event calls
     *
     * @param Request $request
     * @Rest\Post("/nexmo-event", name="event")
     * @return Response
     */
    public function postEvent(Request $request)
    {
        $content = json_decode($request->getContent(), true);
        $this->logger->info('Nexmo event hit', ['content' => $content]);

        $this->eventWorker->batchLater(5)->processEvent($content);

        return new Response('Event successfully registered', Response::HTTP_OK);
    }

    /**
     * Fetch all calls
     *
     * @Rest\Get("/calls", name="call")
     * @return Response
     */
    public function fetchCalls()
    {
        $this->logger->info('Getting Calls');
        $calls = $this->callRepository->findAll();
        $data = new Collection($calls, new CallTransformer());
        $manager = new Manager();
        return new Response($manager->createData($data)->toJson());
    }
}