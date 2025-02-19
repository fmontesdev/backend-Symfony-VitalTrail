<?php

declare(strict_types=1);

namespace App\Auth\Presentation\Mapper;

use App\Auth\Application\Dto\RefreshTokenDto;
use App\Auth\Domain\Entity\RefreshToken;

class RefreshTokenMapper
{
    public function mapDtoToEntity(RefreshTokenDto $dto, ?RefreshToken $entity = null): RefreshToken
    {
        $result = $entity ?: new RefreshToken();
        if ($dto->refreshToken !== null) {
            $result->setRefreshToken($dto->refreshToken);
        }
        if ($dto->username !== null) {
            $result->setUsername($dto->username);
        }
        if ($dto->valid !== null) {
            $result->setValid($dto->valid);
        }
        return $result;
    }

    public function mapEntityToDto(RefreshToken $entity): RefreshTokenDto
    {
        $result = new RefreshTokenDto();
        $result->id = $entity->getId();
        $result->refreshToken = $entity->getRefreshToken();
        $result->username = $entity->getUsername();
        $result->valid = $entity->getValid();
        $result->isValid = $entity->isValid();
        return $result;
    }
}