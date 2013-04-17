<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/functions.php';

require_once __DIR__ . '/../NotORM/NotORM.php';


//SLIM
$app = new Slim\Slim();

//MUSTACHE
$mustache = new Mustache_Engine(array(
        'loader'          => new Mustache_Loader_FilesystemLoader('../src/views/' ),
        'partials_loader' => new Mustache_Loader_FilesystemLoader('../src/views/' ),
));


//Mustache internationalization helper
$mustache->addhelper('i18n', function($text){
	return $text;
	//return __($text);
});



$dsn="mysql:host=localhost;dbname=toppaltest";
//$dsn="dbname=toppaltest";
$username="root";
$password="admin";
$pdo = new PDO($dsn, $username, $password);

$db = new NotORM($pdo);


/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, and `Slim::delete`
 * is an anonymous function.
 */

$app->get('/home(/)', function () use ($app, $mustache) {
    //echo "account information page";
    $page['title'] = "LIST TODO";
    echo $mustache->render('_common/header',array('pageInfo' => $page, 'blank' => true)) . "\n";

    echo $mustache->render('events/index',array('pageInfo' => $page));
    //include '../src/views/account.php';



    echo "\n" . $mustache->render('_common/footer',array('pageInfo' => $page));
});

////new site convention
//$app->get('/:section(/(:page(/)))', function ($section = "search", $page = "index") use ($app, $mustache) {
//
//    $dataPath = "../src/controllers/$section/$page.php";
//    if(file_exists($dataPath)) {
//        $data = json_decode(file_get_contents($dataPath), true);
//    } else {
//        $data = null;
//    }
//
//    $pageInfo['scripts'][] = "/app/$section/$page.js";
//
//    echo $mustache->render('_common/header',array('pageInfo' => $pageInfo)) . "\n";
//    echo $mustache->render("$section/$page",$data) . "\n";
//    echo $mustache->render('_common/footer',null);
//});



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


$app->get("/event/:id", function ($id) use ($app, $db) {
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

$app->run();

