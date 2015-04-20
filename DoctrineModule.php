<?php
namespace Grout\Cyantree\DoctrineModule;

use Cyantree\Grout\App\GroutAppConfig;
use Cyantree\Grout\App\Module;
use Cyantree\Grout\Event\Event;
use Doctrine\Common\Persistence\Mapping\Driver\StaticPHPDriver;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Grout\Cyantree\DoctrineModule\Types\DoctrineConfig;
use Grout\Cyantree\DoctrineModule\Types\SimplifiedFilesystemCache;

class DoctrineModule extends Module
{
    /** @var DoctrineConfig */
    public $moduleConfig;

    /** @var EntityManager */
    private $entityManager;

    public function init()
    {
        $this->app->configs->setDefaultConfig($this->id, new DoctrineConfig());
        $this->moduleConfig = $this->app->configs->getConfig($this->id);

        $this->app->events->join('destroy', array($this, 'onDestroy'));
    }

    public function onDestroy(Event $event)
    {
        if ($this->entityManager && $this->entityManager->isOpen()) {
            $this->entityManager->flush();
            $this->entityManager->close();
        }
    }

    /** @return EntityManager */
    public function getEntityManager()
    {
        if (!$this->entityManager) {
            /** @var GroutAppConfig $c */
            $c = $this->app->getConfig();

            $cache = new SimplifiedFilesystemCache($this->app->cacheStorage->createStorage($this->id . '\\Cache\\'));
            $proxies = $this->app->dataStorage->createStorage($this->id . '\\Proxies\\');
            $config = Setup::createConfiguration($c->developmentMode, $proxies, $cache);
            $driver = new StaticPHPDriver($this->moduleConfig->entityPaths);
            $config->setMetadataDriverImpl($driver);

            if ($c->developmentMode && $this->moduleConfig->logQueries) {
                $config->setSQLLogger(new DoctrineLogger($this->app));
            }

            $connectionDetails = $this->moduleConfig->connectionDetails;

            $this->entityManager = EntityManager::create($connectionDetails->toConfigurationArray(), $config);

            $connectionDetails->onConnected($this->entityManager->getConnection());
        }

        return $this->entityManager;
    }

    public function destroy()
    {
        if ($this->entityManager) {
            $this->entityManager->close();
        }
    }
}
