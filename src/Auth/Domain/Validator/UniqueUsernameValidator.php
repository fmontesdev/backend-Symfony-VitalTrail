<?php

declare(strict_types=1);

namespace App\Auth\Domain\Validator;

use App\Auth\Domain\OutputPort\UserRepository;
use App\Security\Application\SecurityContext;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class UniqueUsernameValidator extends ConstraintValidator
{
    public function __construct(
        private SecurityContext $securityContext,
        private UserRepository $userRepository,
    ) {
    }

    private function isRegistered(string $username): bool
    {
        $profile = $this->userRepository->findByUsername($username);
        return $profile !== null;
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof UniqueUsername) {
            throw new UnexpectedTypeException($constraint, UniqueUsername::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        if ($this->securityContext->isAuthenticated() === true) {
            $user = $this->securityContext->getAuthenticatedUser();
            if ($user && $user->getUsername() === $value){
                return;
            }
        }

        if ($this->isRegistered($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ username }}', $value)
                ->addViolation();
        }
    }
}