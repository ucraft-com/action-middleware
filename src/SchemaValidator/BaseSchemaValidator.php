<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\SchemaValidator;

use JsonSchema\Validator;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Uc\ActionMiddleware\Exceptions\ActionMiddlewareRunException;

abstract class BaseSchemaValidator
{
    abstract public function getSchemaPath(): string;

    public function __construct(
        protected Validator $validator,
        protected LoggerInterface $logger,
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
                $this->logger->error('Error run action middleware.', [
                    'message' => 'Action Middleware data does not validate. Violations: '.$errorMessages
                ]);

                return false;
            }

            return true;
        } catch (Throwable $e) {
            $this->logger->error('Error run action middleware.', [
                'message' => "Schema Validation data failed: {$e->getMessage()}"
            ]);

            return false;
        }
    }
}
