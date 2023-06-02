<?php

namespace Dustin\Filesystem\Local;

use Dustin\Filesystem\FilesystemConfig;
use League\MimeTypeDetection\MimeTypeDetector;

interface MimeTypeDetectorProviderInterface
{
    public function getMimeTypeDetector(FilesystemConfig $config): MimeTypeDetector;
}
