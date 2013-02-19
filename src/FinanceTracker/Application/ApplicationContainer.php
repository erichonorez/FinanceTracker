<?php
namespace FinanceTracker\Application;
use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\XmlDriver;
use FinanceTracker\Infrastructure\Domain\Repositories\Odm\FinanceTrackerUnitOfWork;
use FinanceTracker\Infrastructure\Domain\Repositories\Odm\TransactionRepository;
/**
 * The FinanceTracker Dependency Injection Container
 */
class ApplicationContainer extends \Pimple
{
    /**
     *
     */
    public function __construct()
    {
        $this['baseDir'] = dirname(__DIR__) . '/../../';
        $this['mappingDir'] = $this['baseDir'] . '/src/FinanceTracker/Infrastructure/Domain/Entities/Mappings';
        $this['proxiesDir'] = $this['baseDir'] . '/src/FinanceTracker/Infrastructure/Domain/Entities/Proxies/';
        $this['hydratorsDir'] = $this['baseDir'] . '/src/FinanceTracker/Infrastructure/Domain/Entities/Hydrators/';
        $this['proxiesNamespace'] = 'FinanceTracker\\Infrastructure\\Domain\\Entities\\Proxies';
        $this['hydratorsNamespace'] = 'FinanceTracker\\Infrastructure\\Domain\\Entities\\Hydradors';

        $this['documentManager'] = $this->share(function($container) {
            $config = new Configuration();
            //Configure proxies
            $config->setProxyDir($container['proxiesDir']);
            $config->setProxyNamespace($container['proxiesNamespace']);
            //configure hydrators
            $config->setHydratorDir($container['hydratorsDir']);
            $config->setHydratorNamespace($container['hydratorsNamespace']);
            //instanciate a driver
            $driver = new XmlDriver(array($container['mappingDir']));
            $config->setMetadataDriverImpl($driver);
            //create a new connexion
            return DocumentManager::create(new Connection(), $config);
        });

        $this['transactionRepository'] = $this->share(function($container) {
            return new TransactionRepository($container['documentManager']);
        });

        $this['unitOfWork'] = $this->share(function($container) {
            return new FinanceTrackerUnitOfWork(
                $container['documentManager'],
                $container['transactionRepository']
            );
        });
    }

}