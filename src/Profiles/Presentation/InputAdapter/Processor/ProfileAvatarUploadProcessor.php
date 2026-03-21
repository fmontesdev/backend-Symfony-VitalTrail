<?php

declare(strict_types=1);

namespace App\Profiles\Presentation\InputAdapter\Processor;

use App\Profiles\Application\UseCase\Command\UploadAvatar\UploadAvatarCommand;
use App\Profiles\Presentation\InputAdapter\Resource\ProfileResource;
use App\Security\Application\SecurityContext;
use App\Security\Domain\Exception\UserIsNotAuthenticatedException;
use App\Shared\Application\Exception\InvalidImageFileException;
use App\Shared\Application\InputPort\ApplicationService;
use App\Shared\Application\Service\FileUploadService;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @implements ProcessorInterface<ProfileResource, ProfileResource>
 */
final class ProfileAvatarUploadProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly ApplicationService $service,
        private readonly FileUploadService $fileUploadService,
        private readonly RequestStack $requestStack,
        private readonly SecurityContext $securityContext,
    ) {
    }

    /**
     * @param ProfileResource $data
     * @param Operation $operation
     * @param string[] $uriVariables
     * @param string[][] $context
     * @return ProfileResource
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): ProfileResource
    {
        $user = $this->securityContext->getAuthenticatedUser();
        if ($user === null) {
            throw new UserIsNotAuthenticatedException();
        }

        $request = $this->requestStack->getCurrentRequest();
        $file = $request->files->get('file');

        if ($file === null) {
            throw new InvalidImageFileException('File field is required');
        }

        $userId = str_replace('-', '', (string) $user->getIdUser());
        $filename = $this->fileUploadService->upload($file, 'avatars', $userId);

        $command = new UploadAvatarCommand(
            username: (string) $uriVariables['username'],
            filename: $filename,
        );

        $result = new ProfileResource();
        $result->profile = $this->service->handle($command);

        return $result;
    }
}
