<?php

namespace Dustin\Filesystem\Local;

use Dustin\Filesystem\FilesystemConfig;
use League\Flysystem\UnixVisibility\VisibilityConverter;

interface VisibilityConverterProviderInterface
{
    public function getVisibilityConverter(FilesystemConfig $config): VisibilityConverter;
}
