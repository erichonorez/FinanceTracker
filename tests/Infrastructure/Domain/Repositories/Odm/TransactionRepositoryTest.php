<?php
namespace Tests\Infrastructure\Domain\Repositories\Odm;
use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\XmlDriver;
use FinanceTracker\Infrastructure\Domain\Repositories\Odm\TransactionRepository;
use FinanceTracker\Domain\Entities\Transaction;

class TransactionRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $_transactionRepository;
    private $_documentManager;

    public function setUp()
    {
        $baseDir = dirname(__DIR__) . '/../../../..';
        $mappingDir = $baseDir . '/src/FinanceTracker/Infrastructure/Domain/Entities/Mappings/';
        $proxiesDir = $baseDir . '/src/FinanceTracker/Infrastructure/Domain/Entities/Proxies/';
        $hydratorsDir = $baseDir . '/src/FinanceTracker/Infrastructure/Domain/Entities/Hydrators/';
        $proxiesNamespace = 'FinanceTracker\\Infrastructure\\Domain\\Entities\\Proxies';
        $hydratorsNamespace = 'FinanceTracker\\Infrastructure\\Domain\\Entities\\Hydradors';

        $config = new Configuration();
        //Configure proxies
        $config->setProxyDir($proxiesDir);
        $config->setProxyNamespace($proxiesNamespace);
        //configure hydrators
        $config->setHydratorDir($hydratorsDir);
        $config->setHydratorNamespace($hydratorsNamespace);
        //instanciate a driver
        $driver = new XmlDriver(array($mappingDir));
        $config->setMetadataDriverImpl($driver);
        //create a new connexion
        $this->_transactionRepository = new TransactionRepository(
            $this->_documentManager =
                DocumentManager::create(new Connection(), $config)
        );
    }

    public function testGetRepositoryNameShouldWork()
    {
        $this->assertEquals(
            'FinanceTracker\Domain\Entities\Transaction',
            $this->_transactionRepository->getRepositoryName()
        );
    }

    public function testAddShouldWork()
    {
        $entity = new Transaction();
        $entity->setDescription('Hello, World')
                ->setAmount(100);

        $this->assertInstanceOf(
            'FinanceTracker\Infrastructure\Domain\Repositories\Odm\TransactionRepository',
            $this->_transactionRepository->add($entity)
        );
    }

    /**
     * @expectedException Svomz\Domain\Repositories\EntityNotFoundException
     */
    public function testShouldNotWork()
    {
        $this->_transactionRepository->find(1);
    }
}