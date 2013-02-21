<?php
namespace Tests\Infrastructure\Domain\Repositories\Odm;
use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\XmlDriver;
use FinanceTracker\Infrastructure\Domain\Repositories\Odm\TransactionRepository;
use FinanceTracker\Infrastructure\Domain\Repositories\Odm\TagRepository;
use FinanceTracker\Domain\Entities\Transaction;
use FinanceTracker\Domain\Entities\Tag;

class TransactionRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $_transactionRepository;
    private $_tagRepository;
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
        $connection = new Connection();
        $this->_transactionRepository = new TransactionRepository(
            $this->_documentManager =
                DocumentManager::create($connection, $config)
        );
        $this->_tagRepository = new TagRepository(
            $this->_documentManager
        );
        $connection->dropDatabase('FinanceTracker');
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

        $entity->addTag(new Tag('test'));

        $this->assertInstanceOf(
            'FinanceTracker\Infrastructure\Domain\Repositories\Odm\TransactionRepository',
            $this->_transactionRepository->add($entity)
        );
        $this->_documentManager->flush();
    }

    /**
     * @expectedException Svomz\Domain\Repositories\EntityNotFoundException
     */
    public function testfindShouldNotWork()
    {
        $this->_transactionRepository->find(1);
    }

    public function testGetTransactionsShouldWork()
    {
        $entity = new Transaction();
        $entity->setDescription('Hello, World')
            ->setAmount(100);
        $entity->addTag(new Tag('test'));
        $this->_transactionRepository->add($entity);
        $this->_documentManager->flush();

        $result = $this->_transactionRepository->search(\DateTime::createFromFormat('d-m-Y', '21-10-1987'));
        $this->assertTrue(count($result) > 0);

        $result = $this->_transactionRepository->search(\DateTime::createFromFormat('d-m-Y', '21-10-2018'));
        $this->assertTrue(count($result) === 0);

        $tag = $this->_tagRepository->findByName('test');
        $this->assertNotNull($tag);

        $result = $this->_transactionRepository->search(\DateTime::createFromFormat('d-m-Y', '21-10-1987'), null, array($tag), null);
        $this->assertTrue(count($result) == 1);
    }
}