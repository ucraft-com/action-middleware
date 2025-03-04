<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware;

use Psr\Log\LoggerInterface;
use Throwable;

class ErrorHandler
{
    public function __construct(
        protected LoggerInterface $logger,
    ) {
    }

    /**
     * @param \Throwable $exception
     * @param array      $context
     *
     * @return void
     */
    public function logError(
        Throwable $exception,
        array $context = [],
    ): void {
        $this->logger->error('Exception logged by ActionMiddleware', [
            'message' => $exception->getMessage(),
            'code'    => (string)$exception->getCode(),
            'context' => $context,
        ]);
    }
}
