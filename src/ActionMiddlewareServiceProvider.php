<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware;

use Uc\ActionMiddleware\Exceptions\ActionMiddlewareGatewayConnectionException;
use Uc\ActionMiddleware\Gateways\ActionMiddlewareGateway\ActionMiddlewareGateway;
use Uc\ActionMiddleware\Gateways\ActionMiddlewareGateway\ActionMiddlewareGatewayInterface;
use Uc\ActionMiddleware\Gateways\ActionMiddlewareRunnerGateway\ActionMiddlewareRunnerGateway;
use Uc\ActionMiddleware\Gateways\ActionMiddlewareRunnerGateway\ActionMiddlewareRunnerGatewayInterface;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ActionMiddlewareServiceProvider extends IlluminateServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
    }

    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(ActionMiddlewareGatewayInterface::class, function (): ActionMiddlewareGatewayInterface {
            return $this->getActionMiddlewareGateway();
        });

        $this->app->bind(ActionMiddlewareRunnerGatewayInterface::class, function () {
            return new ActionMiddlewareRunnerGateway(new Client());
        });
    }

    /**
     * @return \Uc\ActionMiddleware\Gateways\ActionMiddlewareGateway\ActionMiddlewareGatewayInterface
     */
    protected function getActionMiddlewareGateway(): ActionMiddlewareGatewayInterface
    {
        throw new ActionMiddlewareGatewayConnectionException(
            'Unable to create ActionMiddlewareGateway. (getActionMiddlewareGateway) method must be overridden in the extended service provider.'
        );
    }
}
