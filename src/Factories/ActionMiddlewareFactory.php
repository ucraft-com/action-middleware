<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\Factories;

use Illuminate\Support\Collection;
use Uc\ActionMiddleware\Enums\ActionMiddlewareType;
use Uc\ActionMiddleware\Gateways\ActionMiddlewareGateway\ActionMiddlewareStruct;
use Uc\ActionMiddleware\SchemaValidator\MiddlewareSchemaValidator;

class ActionMiddlewareFactory
{
    /**
     * @param \Uc\ActionMiddleware\SchemaValidator\MiddlewareSchemaValidator $validator
     * @param array                                                          $data
     *
     * @return \Uc\ActionMiddleware\Gateways\ActionMiddlewareGateway\ActionMiddlewareStruct|null
     */
    public static function createFromResponse(
        MiddlewareSchemaValidator $validator,
        array $data
    ): ?ActionMiddlewareStruct {
        $data['actions'] = json_decode($data['actions'] ?? '[]', true) ?? [];
        $data['headers'] = json_decode($data['headers'] ?? '[]', true) ?? [];
        $data['config'] = json_decode($data['config'] ?? '[]', true) ?? [];

        if ($validator->isValid($data)) {
            $actionMiddleware = new ActionMiddlewareStruct();

            $actionMiddleware->setProjectId((int)($data['projectId']));
            $actionMiddleware->setAlias($data['alias']);
            $actionMiddleware->setEndpoint($data['endpoint']);
            $actionMiddleware->setActive((bool)$data['active']);
            $actionMiddleware->setType(ActionMiddlewareType::from($data['type']));
            $actionMiddleware->setActions($data['actions']);
            $actionMiddleware->setHeaders($data['headers']);
            $actionMiddleware->setConfig($data['config']);

            return $actionMiddleware;
        }

        return null;
    }

    /**
     * @param \Uc\ActionMiddleware\SchemaValidator\MiddlewareSchemaValidator $validator
     * @param array                                                          $responseDataArr
     *
     * @return \Illuminate\Support\Collection
     */
    public static function createCollectionFromResponse(
        MiddlewareSchemaValidator $validator,
        array $responseDataArr
    ): Collection {
        $collection = new Collection();

        foreach ($responseDataArr as $data) {
            $actionMiddleware = self::createFromResponse($validator, $data);

            if ($actionMiddleware) {
                $collection->add($actionMiddleware);
            }
        }


        return $collection;
    }
}
