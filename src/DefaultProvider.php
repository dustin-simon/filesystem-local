<?php

namespace Dustin\Filesystem\Local;

use Dustin\Filesystem\FilesystemConfig;
use League\Flysystem\Local\FallbackMimeTypeDetector;
use League\Flysystem\UnixVisibility\PortableVisibilityConverter;
use League\Flysystem\UnixVisibility\VisibilityConverter;
use League\MimeTypeDetection\FinfoMimeTypeDetector;
use League\MimeTypeDetection\MimeTypeDetector;

class DefaultProvider implements MimeTypeDetectorProviderInterface, VisibilityConverterProviderInterface, WriteFlagsProviderInterface
{
    public function getMimeTypeDetector(FilesystemConfig $config): MimeTypeDetector
    {
        return new FallbackMimeTypeDetector(new FinfoMimeTypeDetector());
    }

    public function getVisibilityConverter(FilesystemConfig $config): VisibilityConverter
    {
        return new PortableVisibilityConverter();
    }

    public function getWriteFlags(FilesystemConfig $config): int
    {
        return \LOCK_EX;
    }
}
