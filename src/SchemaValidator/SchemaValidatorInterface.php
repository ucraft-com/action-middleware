<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\SchemaValidator;

interface SchemaValidatorInterface
{
    /**
     * @param array  $data
     *
     * @return bool
     */
    public function isValid(array $data): bool;
}
