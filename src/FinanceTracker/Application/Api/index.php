<?php
require dirname(dirname(dirname(dirname(__DIR__)))) . '/vendor/autoload.php';

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FinanceTracker\Application\ApplicationContainer;
use FinanceTracker\Domain\Repositories\Transaction\TransactionSearchCriteria;
use Svomz\Domain\Repositories\EntityNotFoundException;
use FinanceTracker\Domain\Entities\Transaction;
use FinanceTracker\Domain\Entities\Tag;

//create an instance of Silex Application and configure the dependency injection container
$application = new Application();
$application['di'] = new ApplicationContainer();
$application['debug'] = true;

/**
 * GET transactions
 */
$application->get('/transactions', function(Request $request) use ($application) {
    // list all transactions
    $params = array(
        'startDate' => $request->query->get('startDate'),
        'endDate' => $request->query->get('endDate'),
        'tags' => $request->query->get('tags'),
        'transactionType' => $request->query->get('transactionType')
    );
    $criteria = new TransactionSearchCriteria($params);

    return $application->json(
        array_values($application['di']['transactionFinder']
            ->find($criteria)
            ->toArray())
    );
});
/**
 * GET a transaction
 */
$application->get('/transactions/{id}', function($id) use ($application) {
    // return transaction identified by the given id
    return $application->json(
        $application['di']['unitOfWork']
            ->getTransactionRepository()
            ->find($id)
    );
});
/**
 * CREATE a transaction
 */
$application->post('/transactions', function(Request $request) use ($application) {
    $factory = $application['di']['transactionFactory'];
    $transaction = $factory->fromObject(json_decode($request->getContent()));

    $unitOfWork = $application['di']['unitOfWork'];
    $unitOfWork->getTransactionRepository()->add($transaction);
    $unitOfWork->commit();

    return new Response($transaction->getTransactionId(), 201);
});
/**
 * UPDATE a transaction
 */
$application->put('/transactions/{id}', function(Request $request, $id) use ($application) {
    $unitOfWork = $application['di']['unitOfWork'];
    $persistedTransaction = $unitOfWork->getTransactionRepository()->find($id);

    $factory = $application['di']['transactionFactory'];
    $transaction = $factory->fromObject(json_decode($request->getContent()));

    $service = $application['di']['transactionService'];
    $service->synchronize($persistedTransaction, $transaction);

    $unitOfWork->commit();
    return new Response($transaction->getTransactionId(), 200);
});
/**
 * DELETE a transaction
 */
$application->delete('/transactions/{id}', function(Request $request, $id) use ($application) {
    // remove a transaction
    $unitOfWork = $application['di']['unitOfWork'];

    $transaction = $unitOfWork->getTransactionRepository()
        ->find($id);

    $unitOfWork->getTransactionRepository()
        ->remove($transaction);

    $unitOfWork->commit();
    return new Response('', 204);
});

$application->error(function (EntityNotFoundException $exception) {
    return new Response('', 404);
});

/*$application->error(function (Exception $exception) {
    return new Response('', 500);
});*/

//run the application
$application->run();