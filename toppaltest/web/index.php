<?php

                                                    require_once __DIR__.'/../vendor/autoload.php';

require_once __DIR__ . '/../NotORM/NotORM.php';

//SLIM
$app = new Slim\Slim();

//MUSTACHE
$mustache = new Mustache_Engine(array(
    'loader'          => new Mustache_Loader_FilesystemLoader('../src/views/', array( 'extension' => ".html" ) ),
    'partials_loader' => new Mustache_Loader_FilesystemLoader('../src/views/', array( 'extension' => ".html" ) ),
));

require_once __DIR__.'/../src/functions.php';

//Mustache internationalization helper
$mustache->addhelper('i18n', function($text){
    //return $text;
    return __($text);
});




//authentication
$auth = function () {

    $user = "authorized";


    //you can't login
    return function () use ( $user ) {
    };
};


/*-----for toppal-----*/
$dsn="mysql:host=localhost;dbname=toppaltest";
//$dsn="dbname=toppaltest";
$username="root";
$password="admin";
$pdo = new PDO($dsn, $username, $password);

$db = new NotORM($pdo);

//$app->get('/eventlist(/)',  $auth(), function () use ($app, $db) {
$app->get('/eventlist(/)', function () use ($app, $mustache,$db) {
    //$app->get('/players(/)', $auth(), function () use ($app, $mustache) {
    $events = array();
    foreach ($db->todolist() as $event) {
        $events[]  = array(
            "id" => $event["id"],
            "name" => $event["name"],
            "date" => $event["date"],
            "priority" => $event["priority"],
            "status" => $event["status"],
            "description" => $event["description"]
        );
    }
    $app->response()->header("Content-Type", "application/json");
    echo json_encode($events);
});


$app->get('/event/:id', function ($id) use ($app, $db) {
    $app->response()->header("Content-Type", "application/json");
    $event = $db->todolist()->where("id", $id);

    if ($data = $event->fetch()) {
        echo json_encode(array(
            "id" => $data["id"],
            "title" => $data["title"],
            "author" => $data["author"],
            "summary" => $data["summary"]
        ));
    }
    else{
        echo json_encode(array(
            "status" => false,
            "message" => "Book ID $id does not exist"
        ));
    }
});


//Adding and Editing Books

$app->post("/eventadd", function () use($app, $db) {
    $app->response()->header("Content-Type", "application/json");
    $event = $app->request()->post();
    $result = $db->todolist->insert($event);
    echo json_encode(array("id" => $result["id"]));
});

$app->put("/eventupdate/:id", function ($id) use ($app, $db) {
    $app->response()->header("Content-Type", "application/json");
    $book = $db->books()->where("id", $id);
    if ($book->fetch()) {
        $post = $app->request()->put();
        $result = $book->update($post);
        echo json_encode(array(
            "status" => (bool)$result,
            "message" => "Book updated successfully"
        ));
    }
    else{
        echo json_encode(array(
            "status" => false,
            "message" => "Book id $id does not exist"
        ));
    }
});

$app->get('/home(/)', $auth(),function () use ($app, $mustache) {
    //echo "account information page";
//    $page['title'] = "LIST TODO";
//    echo $mustache->render('_common/header',array('pageInfo' => $page, 'blank' => true)) . "\n";
//
//   // echo $mustache->render('events/index',array('pageInfo' => $page));
//    //include '../src/views/account.php';
//    echo "\n" . $mustache->render('_common/footer',array('pageInfo' => $page));

    $page['title'] = "Home";
    $page['home_active'] = true;
    echo $mustache->render('_common/header',array('pageInfo' => $page)) . "\n";
    require_once '../src/views/home.php';
    echo "\n" . $mustache->render('_common/footer',array('pageInfo' => $page));

});

$app->get('/players', $auth(), function () use ($app, $mustache,$db) {
    $page['title'] = __("Events");
    $page['todolist_active'] = true;
    echo $mustache->render('_common/header',array('pageInfo' => $page));
    include '../src/views/players.php';
    //echo $mustache->render('_common/footer',array('pageInfo' => $page));
});

$app->get('/addevent', $auth(), function () use ($app, $mustache) {
    $page['title'] = "AddEvents";
    $page['addevent_active'] = true;
    echo $mustache->render('_common/header',array('pageInfo' => $page));
    include '../src/views/addevent.php';
    //echo $mustache->render('_common/footer',array('pageInfo' => $page));
});







/*----------------toppal***-----*/
$app->get('/eventlist(/)', function () use ($app, $db) {
    $events = array();
    foreach ($db->todolist() as $event) {
        $events[]  = array(
            "id" => $event["id"],
            "name" => $event["name"],
            "date" => $event["date"],
            "priority" => $event["priority"],
            "status" => $event["status"],
            "description" => $event["description"]
        );
    }
    $app->response()->header("Content-Type", "application/json");
    echo json_encode($events);
});


$app->get('/', function () use ($app) {
    $app->redirect("home");
});



//custom not found handler
$app->notFound(function () use ($app, $mustache) {
    $page['title'] = __("File Not Found");
    echo $mustache->render('_common/header',array('pageInfo' => $page, 'blank' => true)) . "\n";
    include '../src/views/filenotfound.php';
    echo "\n" . $mustache->render('_common/footer',array('pageInfo' => $page));
});
/*for new analytics dashboard */



//$app = new \Slim\Slim(array('debug' => true));
$app->view()->setData('app', $app);

$localeLoockup = array(
    'en' => 'en_US',
    'es' => 'es_AR',
    'ru' => 'ru_RU'
);

/*** Routes for front end *****************************************************/

$app->get('/', function() use ($app) {
    $app->redirect('/summary/');
});



/*** Error handlers ***********************************************************/

$app->notFound(function () use ($app) {
    $app->render('404.php');
});

/*end analitycs dashboard*/


$app->run();

/*
if(isset( $_SESSION['SSMData'])) {
	echo "\n<hr>SESSION : <pre>" . print_r( $_SESSION['SSMData'],true) . "</pre><hr>\n";
}
*/