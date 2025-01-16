<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\SchemaValidator;

class ValidationResponseSchemaValidator extends BaseSchemaValidator implements SchemaValidatorInterface
{
    protected string $schemaPath = __DIR__.'/../../schemas/actionMiddlewareRunner/validation/response-schema.json';

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
