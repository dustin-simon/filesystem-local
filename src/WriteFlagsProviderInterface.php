<?php

namespace Dustin\Filesystem\Local;

use Dustin\Filesystem\FilesystemConfig;

interface WriteFlagsProviderInterface
{
    public function getWriteFlags(FilesystemConfig $config): int;
}
