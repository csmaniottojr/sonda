<?php

ini_set('display_errors', true);

require_once './autoload.php';

use Slim\Slim;
use comunic\social_network_analyzer\model\facade\FacadeFactory;
use comunic\social_network_analyzer\model\repository\mongo\MongoRepository;
use comunic\social_network_analyzer\model\entity\parse\json\JsonCategoryParser;
use comunic\social_network_analyzer\model\entity\format\json\JsonCategoryFormatter;
use comunic\social_network_analyzer\model\entity\parse\json\JsonTweetParser;
use comunic\social_network_analyzer\model\entity\format\json\JsonTweetFormatter;
use comunic\social_network_analyzer\model\entity\parse\csv\CSVTweetParser;
use comunic\social_network_analyzer\model\entity\parse\csv\CSVCategoryParser;


use comunic\social_network_analyzer\model\entity\format\json\JsonPaginator;
use comunic\social_network_analyzer\model\entity\mappers\TweetToArray;
$restapp = new Slim();


$mongo = new MongoRepository();
$mfact = new FacadeFactory($mongo);

$categoryFacade = $mfact->instantiateCategories();

$restapp->get('/categories/json', function() use ($categoryFacade) {

    echo $categoryFacade->listAll(new JsonCategoryFormatter());
});

$restapp->get('/categories/json/:id', function($id) use ($categoryFacade) {

    echo $categoryFacade->findById($id, new JsonCategoryFormatter());
});

$restapp->post('/categories/json', function() use ($categoryFacade, $restapp) {

    $categoryFacade->insert($restapp->request()->getBody(), new JsonCategoryParser());
    echo "Categoria adicionada com sucesso.";
});

$restapp->put('/categories/json', function() use ($categoryFacade, $restapp) {

    echo $categoryFacade->update($restapp->request()->getBody(), new JsonCategoryParser());
});

$restapp->delete('/categories/json/:id', function($id) use ($categoryFacade) {

    $categoryFacade->delete($id);
    echo "Categoria removida com sucesso.";
});

$tweetFacade = $mfact->instantiateTweets();

$restapp->get('/tweets/json', function() use($tweetFacade) {
    echo $tweetFacade->listAll(new JsonTweetFormatter());
});

$restapp->get('/tweets/json/:id', function($id) use($tweetFacade) {
    echo $tweetFacade->findById($id, new JsonTweetFormatter());
});

$restapp->get('/tweets/json/find_by_category/:idCat', function($idCat) use($tweetFacade) {
    echo $tweetFacade->findByCategory($idCat, new JsonTweetFormatter());
});

$restapp->post('/tweets/json', function() use($tweetFacade, $restapp) {
   $tweetFacade->insertAll($restapp->request()->getBody(), new JsonTweetParser());
   echo "Tweets importados com sucesso.";
});


$restapp->post('/tweets/csv_to_json', function()use($restapp) {
    $parserT = new CSVTweetParser();
    $formatter = new JsonTweetFormatter();

    $tweets = $parserT->parse($restapp->request()->getBody());

    $restapp->response()->setBody($formatter->format($tweets));

});

$restapp->post('/categories/import_csv', function() use ($restapp, $categoryFacade){
    $parseC = new CSVCategoryParser();
    $formatter = new JsonCategoryFormatter();


    $categories = $parseC->parse($restapp->request()->getBody());

    echo $restapp->request()->getBody();
    echo var_dump($restapp->request()->getBody());

    //echo $categories;
    echo var_dump($categories);

    $jsonCat = $formatter->format($categories);

    $categoryFacade->insertAll($jsonCat, new JsonCategoryParser());

});



$restapp->get('/tweets/json/:page/:amount', function($page, $amount) use($tweetFacade) {

    echo $tweetFacade->listInAnInterval(new JsonPaginator(new TweetToArray()), $page, $amount);
});





$restapp->get('/tweets/json/find_by_category/:idCat/:page/:amount', function($idCat, $page, $amount) use($tweetFacade) {
   echo $tweetFacade->findbyCategoryInAnInterval($idCat, new JsonPaginator(new TweetToArray()), $page, $amount);
});


$restapp->get('/testte/', function() {
    require_once 'teste.php';
});

$restapp->get("/query/", function() use($restapp){

if (!is_null($restapp->request()->get('plau'))){
    echo "existe";
}else{
    echo "não existe";
}
});



$restapp->run();
?>
