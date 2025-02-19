<?php

declare(strict_types=1);

namespace App\Auth\Domain\Validator;

use App\Auth\Domain\OutputPort\UserRepository;
use App\Security\Application\SecurityContext;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class UniqueEmailValidator extends ConstraintValidator
{
    public function __construct(
        private SecurityContext $securityContext,
        private UserRepository $userRepository,
    ) {
    }

    private function isRegistered(string $email): bool
    {
        $user = $this->userRepository->findByEmail($email);
        return $user !== null;
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof UniqueEmail) {
            throw new UnexpectedTypeException($constraint, UniqueEmail::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        if ($this->securityContext->isAuthenticated() === true) {
            $user = $this->securityContext->getAuthenticatedUser();
            if ($user && $user->getEmail() === $value){
                return;
            }
        }

        if ($this->isRegistered($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ email }}', $value)
                ->addViolation();
        }
    }
}
