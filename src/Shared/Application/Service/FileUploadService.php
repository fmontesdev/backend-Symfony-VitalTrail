<?php

declare(strict_types=1);

namespace App\Shared\Application\Service;

use App\Shared\Application\Exception\InvalidImageFileException;
use App\Shared\Application\Exception\InvalidUploadSubdirectoryException;
use App\Shared\Application\Exception\UploadDirectoryNotWritableException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class FileUploadService
{
    private const ALLOWED_MIME_TYPES = [
        'image/avif',
        'image/webp',
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/svg+xml',
    ];

    private const MAX_FILE_SIZE = 5 * 1024 * 1024;

    public function __construct(
        #[Autowire('%app.uploads.routes_dir%')]
        private readonly string $routesDir,
        #[Autowire('%app.uploads.avatars_dir%')]
        private readonly string $avatarsDir,
    ) {
    }

    public function upload(UploadedFile $file, string $subdirectory, string $entityId): string
    {
        $this->validateMime($file);
        $this->validateSize($file);

        [$prefix, $targetDir] = match ($subdirectory) {
            'routes'  => ['route-' . $entityId,  $this->routesDir],
            'avatars' => ['avatar-' . $entityId, $this->avatarsDir],
            default   => throw new InvalidUploadSubdirectoryException($subdirectory),
        };

        if (!is_writable($targetDir)) {
            throw new UploadDirectoryNotWritableException($targetDir);
        }

        $filename = $prefix . '-' . bin2hex(random_bytes(8)) . '.' . strtolower((string) $file->getClientOriginalExtension());

        $file->move($targetDir, $filename);

        return $filename;
    }

    private function validateMime(UploadedFile $file): void
    {
        if (!$file->isValid()) {
            throw new InvalidImageFileException(
                sprintf('Upload failed: %s', $file->getErrorMessage())
            );
        }

        $path = $file->getPathname();

        if (!is_file($path)) {
            throw new InvalidImageFileException();
        }

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($path);

        if ($mimeType === false || !in_array($mimeType, self::ALLOWED_MIME_TYPES, true)) {
            throw new InvalidImageFileException(
                sprintf('MIME type "%s" is not allowed', $mimeType ?: 'unknown')
            );
        }
    }

    private function validateSize(UploadedFile $file): void
    {
        if ($file->getSize() > self::MAX_FILE_SIZE) {
            throw new InvalidImageFileException('File exceeds maximum allowed size of 5 MB');
        }
    }
}
