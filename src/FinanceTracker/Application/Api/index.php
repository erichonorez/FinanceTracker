<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

require dirname(dirname(dirname(dirname(__DIR__)))) . '/vendor/autoload.php';
//create an instance of Silex Application and configure the dependency injection container
$application = new Silex\Application();
$application['di'] = new FinanceTracker\Application\ApplicationContainer();

//configure routes
$application->get('/transactions', function(Symfony\Component\HttpFoundation\Request $request) use ($application) {
    // list all transactions
    $params = array(
        'startDate' => $request->query->get('startDate'),
        'endDate' => $request->query->get('endDate'),
        'tags' => $request->query->get('tags'),
        'transactionType' => $request->query->get('transactionType')
    );
    $criteria = new FinanceTracker\Domain\Repositories\Transaction\TransactionSearchCriteria($params);
    return $application->json(
        $application['di']['transactionFinder']->find($criteria)->toArray()
    );
});
$application->get('/transactions/{id}', function($id) use ($application) {
    // return transaction identified by the given id
    return $application->json(
        $application['di']['unitOfWork']->getTransactionRepository()->find($id)
    );
});
$application->post('/transactions', function(Symfony\Component\HttpFoundation\Request $request) use ($application) {
    // create an new transaction
    $values = json_decode($request->getContent());
    $transaction = new FinanceTracker\Domain\Entities\Transaction();
    $transaction->setDescription($values->description);
    $transaction->setDate($values->date);
    $transaction->setAmount($values->amount);
    foreach ($values->tags as $tag) {
        $tag = new FinanceTracker\Domain\Entities\Tag();
        $transaction->addTag($tag);
    }
    $uow = $application['di']['unitOfWork'];
    $uow->getTransactionRepository()->add($transaction);
    $uow->commit();
    return $application->json('ok');
});
$application->put('/transactions/{id}', function($id) use ($application) {
    $uow = $application['di']['unitOfWork'];
    $transaction = $uow->getTransactionRepository()->find($id);
    $transaction = new FinanceTracker\Domain\Entities\Transaction();
    $transaction->setDescription($values->description);
    $transaction->setDate($values->date);
    $transaction->setAmount($values->amount);
    foreach ($values->tags as $tag) {
        $tag = new FinanceTracker\Domain\Entities\Tag();
        $transaction->addTag($tag);
        if (!$transaction->hasTag($tag)) {
            $transaction->addTag($tag);
        }
    }
    $uow->commit();
    return $application->json('ok');
});
$application->delete('/transactions/{id}', function($id) use ($application) {
   // remove a transaction
    $transaction = $application['di']['unitOfWork']->getTransactionRepository()->find($id);
    $application['di']['unitOfWork']->getTransactionRepository()->remove($transaction);
    return $application->json(
        'ok'
    );
});

//run the application
$application->run();