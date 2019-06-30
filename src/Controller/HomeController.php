<?php

namespace App\Controller;

use App\Entity\CallEntity;
use App\Repository\CallEntityRepository;
use App\Service\NexmoService;
use App\Transformer\CallTransformer;
use Doctrine\ORM\EntityNotFoundException;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\ArraySerializer;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    /** @var NexmoService */
    private $nexmoService;

    /** @var Logger */
    private $logger;

    /** @var CallEntityRepository */
    private $callRepository;

    public function __construct(NexmoService $nexmoService, CallEntityRepository $callRepository, LoggerInterface $logger)
    {
        $this->nexmoService = $nexmoService;
        $this->logger = $logger;
        $this->callRepository = $callRepository;
    }

    /**
     * @Route("/", name="home")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function home(Request $request)
    {
        $message = $request->get('message');
        $type = $request->get('type');
        $receiverNumber = $request->get('number');

        if ($type) {
            switch ($type) {
                case '1':
                    $this->nexmoService->makeCall($message, $receiverNumber);
                    return $this->redirectToRoute('success', ['messageType' => 'Call']);
                case '2':
                    $this->nexmoService->sendSMS($message);
                    return $this->render('success.html.twig', ['messageType' => 'Text message']);
                default:
                    throw new \Exception('Message Type not specified');
            }
        }

        $this->logger->info('Home page being rendered');

        return $this->render('home.html.twig');
    }

    /**
     * @Route("/success", name="success")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function successPage(Request $request)
    {
        return $this->render('success.html.twig', ['messageType' => $request->get('messageType')]);
    }

    /**
     * @Route("/calls", name="view_calls")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function viewAllCalls()
    {
        return $this->render('calls.html.twig');
    }

    /**
     * @Route("/calls/{id}", name="view_single_call")
     */
    public function viewSingleCall($id)
    {
        $call = $this->callRepository->find($id);

        if (!$call instanceof CallEntity) {
            throw new EntityNotFoundException('Call not found');
        }

        return $this->render('single-call.html.twig', ['call' => $call]);
    }
}