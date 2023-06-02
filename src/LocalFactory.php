<?php

namespace Dustin\Filesystem\Local;

use Dustin\Filesystem\Exception\ConfigException;
use Dustin\Filesystem\Factory\FilesystemFactoryInterface;
use Dustin\Filesystem\FilesystemConfig;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemOperator;
use League\Flysystem\Local\LocalFilesystemAdapter;

class LocalFactory implements FilesystemFactoryInterface
{
    public const TYPE = 'local';

    /**
     * @var DefaultProvider|null
     */
    private $defaultProvider;

    public function __construct(
        private ?VisibilityConverterProviderInterface $visibilityConverterProvider = null,
        private ?WriteFlagsProviderInterface $writeFlagsProvider = null,
        private ?MimeTypeDetectorProviderInterface $mimeTypeDetectorProvider = null
    ) {
        $this->$visibilityConverterProvider = $visibilityConverterProvider ?: ($this->defaultProvider = ($this->defaultProvider ?: new DefaultProvider()));
        $this->writeFlagsProvider = $writeFlagsProvider ?: ($this->defaultProvider = ($this->defaultProvider ?: new DefaultProvider()));
        $this->mimeTypeDetectorProvider = $mimeTypeDetectorProvider ?: ($this->defaultProvider = ($this->defaultProvider ?: new DefaultProvider()));
    }

    public function getType(): string
    {
        return self::TYPE;
    }

    public function createFilesystem(FilesystemConfig $filesystemConfig): FilesystemOperator
    {
        $config = $filesystemConfig->getConfig();

        if ($config === null) {
            throw ConfigException::incomplete();
        }

        $adapter = new LocalFilesystemAdapter(
            (string) $config->get('root'),
            $this->visibilityConverterProvider->getVisibilityConverter($filesystemConfig),
            $this->writeFlagsProvider->getWriteFlags($filesystemConfig),
            $config->get('linkHandling') ?? LocalFilesystemAdapter::DISALLOW_LINKS,
            $this->mimeTypeDetectorProvider->getMimeTypeDetector($filesystemConfig),
            !(bool) $config->get('createRootOnConnection')
        );

        return new Filesystem($adapter);
    }
}
