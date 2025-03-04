<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\SchemaValidator;

use JsonSchema\Validator;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Uc\ActionMiddleware\ErrorHandler;
use Uc\ActionMiddleware\Exceptions\SchemaValidatorException;

abstract class BaseSchemaValidator
{
    abstract public function getSchemaPath(): string;

    public function __construct(
        protected Validator $validator,
        protected ErrorHandler $errorHandler,
    ) {
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    public function validate(array $data): bool
    {
        try {
            $schema = json_decode(file_get_contents($this->getSchemaPath()));

            $this->validator->validate($data, $schema);

            if (!$this->validator->isValid()) {
                $errors = [];
                foreach ($this->validator->getErrors() as $error) {
                    $errors[] = sprintf("[%s] %s", $error['property'], $error['message']);
                }
                $errorMessages = implode("\n", $errors);

                throw new SchemaValidatorException('Action Middleware data does not validate. Violations: '.$errorMessages, Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            return true;
        } catch (Throwable $e) {
            $this->errorHandler->logError($e);

            return false;
        }
    }
}
