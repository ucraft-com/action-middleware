<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware;

use Uc\ActionMiddleware\Gateways\ActionMiddlewareGateway\ActionMiddlewareGateway;
use Uc\ActionMiddleware\Gateways\ActionMiddlewareGateway\ActionMiddlewareGatewayInterface;
use Uc\ActionMiddleware\Gateways\ActionMiddlewareRunnerGateway\ActionMiddlewareRunnerGateway;
use Uc\ActionMiddleware\Gateways\ActionMiddlewareRunnerGateway\ActionMiddlewareRunnerGatewayInterface;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ActionMiddlewareServiceProvider extends IlluminateServiceProvider
{
    /**
     * @var string
     */
    protected string $config = __DIR__.'/../config/action-middleware.php';

    /**
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([$this->config => $this->app->configPath('action-middleware.php'),], 'action-middleware');
        }
    }

    /**
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom($this->config, 'action-middleware');

        $this->app->bind(ActionMiddlewareGatewayInterface::class, function (): ActionMiddlewareGatewayInterface {
            return $this->getActionMiddlewareGateway();
        });

        $this->app->singleton(ActionMiddlewareRunnerGatewayInterface::class, function () {
            return new ActionMiddlewareRunnerGateway(new Client());
        });
    }

    /**
     * @return \Uc\ActionMiddleware\Gateways\ActionMiddlewareGateway\ActionMiddlewareGatewayInterface
     */
    protected function getActionMiddlewareGateway(): ActionMiddlewareGatewayInterface
    {
        return new ActionMiddlewareGateway();
    }
}
