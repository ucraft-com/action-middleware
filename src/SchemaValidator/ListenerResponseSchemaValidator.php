<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\SchemaValidator;

class ListenerResponseSchemaValidator extends BaseSchemaValidator implements SchemaValidatorInterface
{
    protected string $schemaPath = '/../../schemas/actionMiddlewareRunner/listener/response-schema.json';

    /**
     * @param array $data
     *
     * @return bool
     */
    public function isValid(array $data): bool
    {
        return $this->validate($data);
    }

    /**
     * @return string
     */
    public function getSchemaPath(): string
    {
        return $this->schemaPath;
    }
}
