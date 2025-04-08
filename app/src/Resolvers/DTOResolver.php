<?php

namespace App\Resolvers;

use App\Exceptions\InvalidDtoArguments;
use App\Requests\RequestDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DTOResolver implements ValueResolverInterface
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $type = $argument->getType();
        if ($type === null || !is_a($type, RequestDTO::class, true)) {
            return [];
        }
        $data = $request->getContent();
        if (empty($data)) {
            $dto = new ($type)();
        } else {
            try {
                $dto = $this->serializer->deserialize($data, $type, 'json');
            } catch (NotEncodableValueException|NotNormalizableValueException $e) {
                throw new InvalidDtoArguments([]);
            }
        }
        $violations = $this->validator->validate($dto);
        if (count($violations) > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[$violation->getPropertyPath()] = $violation->getMessage();
            }
            throw new InvalidDtoArguments($errors);
        }
        yield $dto;
    }
}