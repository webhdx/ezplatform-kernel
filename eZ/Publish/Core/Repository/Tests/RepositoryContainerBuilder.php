<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace eZ\Publish\Core\Repository\Tests;

use eZ\Publish\API\Repository\Tests\Container\Compiler\SetAllServicesPublicPass;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Filesystem\Filesystem as FilesystemComponent;

/**
 * Symfony Container Builder for eZ Platform Repository.
 *
 * @internal for internal use by Repository tests
 */
final class RepositoryContainerBuilder
{
    /** @var \Symfony\Component\DependencyInjection\TaggedContainerInterface */
    private $containerBuilder;

    public function __construct(ContainerBuilder $containerBuilder)
    {
        $this->containerBuilder = $containerBuilder;
    }

    public function buildTestContainer(): void
    {
        $installDir = dirname(__DIR__, 5);

        $settingsPath = "{$installDir}/eZ/Publish/Core/settings/";
        $loader = new YamlFileLoader($this->containerBuilder, new FileLocator($settingsPath));

        $loader->load('fieldtypes.yml');
        $loader->load('io.yml');
        $loader->load('repository.yml');
        $loader->load('repository/inner.yml');
        $loader->load('repository/event.yml');
        $loader->load('repository/siteaccessaware.yml');
        $loader->load('repository/autowire.yml');
        $loader->load('fieldtype_external_storages.yml');
        $loader->load('storage_engines/common.yml');
        $loader->load('storage_engines/shortcuts.yml');
        $loader->load('storage_engines/legacy.yml');
        $loader->load('search_engines/legacy.yml');
        $loader->load('storage_engines/cache.yml');
        $loader->load('settings.yml');
        $loader->load('fieldtype_services.yml');
        $loader->load('utils.yml');
        $loader->load('tests/common.yml');
        $loader->load('tests/integration_legacy.yml');
        $loader->load('policies.yml');
        $loader->load('events.yml');
        $loader->load('thumbnails.yml');

        $this->containerBuilder->setParameter('ezpublish.kernel.root_dir', $installDir);

        $this->containerBuilder->setParameter(
            'legacy_dsn',
            $this->getDsn()
        );
        $this->containerBuilder->setParameter(
            'io_root_dir',
            $this->createStorageDir('/var/ezdemo_site/storage')
        );

        $this->containerBuilder->addCompilerPass(new SetAllServicesPublicPass());
    }

    private function createStorageDir(string $path): string
    {
        $storageDir = sys_get_temp_dir() . '/eZ_tests_' . md5(__CLASS__) . $path;
        if (!file_exists($storageDir)) {
            $fs = new FilesystemComponent();
            $fs->mkdir($storageDir);
        }
    }
}
