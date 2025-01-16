<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\SchemaValidator;

class MiddlewareSchemaValidator extends BaseSchemaValidator implements SchemaValidatorInterface
{
    protected string $schemaPath = __DIR__.'/../../schemas/actionMiddleware/actionMiddleware-schema.json';

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
