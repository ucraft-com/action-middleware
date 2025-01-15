<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\Gateways\ActionMiddlewareGateway;

use Uc\ActionMiddleware\Exceptions\ActionMiddlewareGatewayConnectionException;

class ActionMiddlewareGateway implements ActionMiddlewareGatewayInterface
{
    /**
     * @return array
     * @throws \Exception
     */
    public function getMiddlewares(): array
    {
        throw new ActionMiddlewareGatewayConnectionException('Unable to create ActionMiddlewareGateway');
    }
}
