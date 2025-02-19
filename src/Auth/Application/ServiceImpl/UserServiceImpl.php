<?php

declare(strict_types=1);

namespace App\Auth\Application\ServiceImpl;

use App\Auth\Application\InputPort\UserService;
use App\Auth\Application\Dto\UserDto;
use App\Auth\Presentation\Mapper\UserMapper;
use App\Auth\Domain\Entity\User;
use App\Auth\Domain\OutputPort\UserRepository;
use App\Auth\Application\ServiceImpl\AdminServiceImpl;
use App\Auth\Application\ServiceImpl\ClientServiceImpl;
use App\Auth\Application\Exception\EmailIsNotValidException;
use App\Auth\Application\Exception\PasswordIsNotValidException;
use App\Security\Application\SecurityContext;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Security\Application\Jwt\JwtTokenGenerator;
use App\Security\Domain\Exception\UserIsNotAuthenticatedException;

class UserServiceImpl implements UserService
{
    public function __construct(
        private SecurityContext $securityContext,
        private UserMapper $userMapper,
        private UserRepository $userRepository,
        private AdminServiceImpl $adminServiceImpl,
        private ClientServiceImpl $clientServiceImpl,
        private UserPasswordHasherInterface $passwordHasher,
        private JwtTokenGenerator $jwtTokenGenerator,
    ) {
    }

    private function getContextUser(): User
    {
        return $this->securityContext->getAuthenticatedUser();
    }

    private function save(UserDto $data, ?User $user = null): User
    {
        $result = $this->userMapper->mapDtoToEntity($data, $user);
        if ($data->password !== null) {
            $result->setPassword($this->passwordHasher->hashPassword($result, $data->password));
        }
        $this->userRepository->save($result);
        return $result;
    }

    private function toDto(User $user, string $token = null, string $refreshToken = null): UserDto
    {
        $result = $this->userMapper->mapEntityToDto($user);
        $result->token = $token;
        $result->refreshToken = $refreshToken;
        return $result;
    }

    public function registerUser(UserDto $data): UserDto
    {
        $user = $this->save($data);

        if (isset($data->admin)) {
            $user = $this->adminServiceImpl->registerAdmin($user, $data);
        }
        if (isset($data->client)) {
            $user = $this->clientServiceImpl->registerClient($user, $data);
        }

        return $this->toDto($user);
    }

    public function loginUser(UserDto $data): UserDto
    {
        $user = $this->userRepository->findByEmail((string) $data->email);
        if ($user === null) {
            throw new EmailIsNotValidException();
        }
        if (!$this->passwordHasher->isPasswordValid($user, (string) $data->password)) {
            throw new PasswordIsNotValidException();
        }

        $token = $this->jwtTokenGenerator->createAccessToken($user);
        $refreshToken = $this->jwtTokenGenerator->createRefreshToken($user);

        return $this->toDto($user, $token, $refreshToken);
    }

    public function getCurrentUser(): UserDto
    {
        $user = $this->getContextUser();
        if ($user === null) {
            throw new UserIsNotAuthenticatedException();
        }
        return $this->toDto($user);
    }

    public function updateCurrentUser(UserDto $data): UserDto
    {
        $user = $this->getContextUser();
        if ($user === null) {
            throw new UserIsNotAuthenticatedException();
        }

        $this->save($data, $user);
        return $this->toDto($user);
    }
}
