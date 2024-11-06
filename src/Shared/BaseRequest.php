<?php

namespace App\Shared;

use App\Shared\Response\ConstraintViolation;
use App\Shared\Response\Exception\ValidatorException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Webmozart\Assert\Assert;

abstract class BaseRequest
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator,
    ) {
        $this->hydrate();
        $this->validate();
    }

    public function validate()
    {
        $errors = $this->validator->validate($this);
        $messages = [];
        if (count($errors) > 0) {
            foreach ($errors as $message) {
                $messages[] = new ConstraintViolation(
                    $message->getPropertyPath(),
                    $message->getInvalidValue(),
                    $message->getMessage(),
                );
            }

            throw new ValidatorException($messages);
        }
    }

    public function getRequest(): Request
    {
        return Request::createFromGlobals();
    }

    protected function hydrate(): void
    {
        $request = $this->requestStack->getCurrentRequest();
        Assert::notNull($request);

        $this->serializer->deserialize(
            $request->getContent(),
            static::class,
            'json',
            ['object_to_populate' => $this]
        );
    }
}
