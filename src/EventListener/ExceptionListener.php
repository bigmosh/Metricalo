<?php
namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ExceptionListener
{
  private $logger;
  public function __construct(LoggerInterface $logger)
  {
      $this->logger = $logger;
  }
    public function __invoke(ExceptionEvent $event): void
    {

        $exception = $event->getThrowable();
        $previousException = $exception->getPrevious();
        $defaultErrorResponse = [
          'status' =>  'error', 
          'message' => $exception->getMessage(),
          'code' => JsonResponse::HTTP_BAD_REQUEST,
        ];

        $customErrorResponse = [];
        if ($exception && $previousException instanceof ValidationFailedException) {
          $customErrorResponse['message'] = 'Validation failed'; 
          $customErrorResponse['code'] = JsonResponse::HTTP_BAD_REQUEST;  
          // $customErrorResponse['errors'] = ;
        }else {
          $this->logger->error('No it not');
        }

        $response = new JsonResponse(array_merge($defaultErrorResponse), JsonResponse::HTTP_BAD_REQUEST);
        $event->setResponse($response);
    }
}