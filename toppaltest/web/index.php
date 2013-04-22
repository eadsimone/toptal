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

//get all event
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

//get a particular event
$app->get('/event/:id', function ($id) use ($app, $db) {
    $app->response()->header("Content-Type", "application/json");
    $event = $db->todolist()->where("id", $id);

    if ($data = $event->fetch()) {
        $resp=array("responseCode"=>"1000");
        $obj= array(
            "id" => $data["id"],
            "name" => $data["name"],
            "date" => $data["date"],
            "priority" => $data["priority"],
            "status" => $data["status"],
            "description" => $data["description"]
        );
        $resptext=array("responseText"=>"successful");

        $resp=array("responseCode"=>"1000","responseObject"=>$obj,"responseText"=>"successful","status" =>true);

        echo json_encode($resp);
    }
    else{
        echo json_encode(array(
            "status" => false,
            "message" => "Book ID $id does not exist"
        ));
    }
});


//Add event
$app->post("/eventadd", function () use($app, $db) {
    $app->response()->header("Content-Type", "application/json");
    $event = $app->request()->post();
    $result = $db->todolist->insert($event);

    $obj= array(
        "id" => $result->offsetGet("id"),
        "name" => $result->offsetGet("name"),
        "date" => $result->offsetGet("date"),
        "priority" => $result->offsetGet("priority"),
        "status" => $result->offsetGet("status"),
        "description" => $result->offsetGet("description")
    );

    $resp=array("responseCode"=>"1000","responseObject"=>$obj,"responseText"=>"successful","status" =>true);

    echo json_encode($resp);
});

//update a particular event
$app->post("/eventupdate/:id", function ($id) use ($app, $db) {
    $app->response()->header("Content-Type", "application/json");
    $event = $db->todolist()->where("id", $id);
    if ($event->fetch()) {
        $post = $app->request()->put();
        $result = $event->update($post);

        if($result==1){
            $obj= array(
                "id" => $id,
                "name" => $post['name'],
                "date" => $post['date'],
                "priority" => $post['priority'],
                "status" => $post['status'],
                "description" => $post['description']
            );

            $resp=array("responseCode"=>"1000","responseObject"=>$obj,"responseText"=>"successful","status" =>true);

            echo json_encode($resp);
        }else{
            echo json_encode(array(
                "status" => false,
                "message" => "Book id $id does not exist"
            ));
        }
        /*
                echo json_encode(array(
                    "status" => (bool)$result,
                    "message" => "Book updated successfully"
                ));
        */
    }
    else{
        echo json_encode(array(
            "status" => false,
            "message" => "Book id $id does not exist"
        ));
    }
});

//delete a particular event
$app->get('/deleteevent/:id',$auth(), function ($id) use($app, $db) {
    $app->response()->header("Content-Type", "application/json");
    $event = $db->todolist()->where("id", $id);
    if ($event->fetch()) {
        $result = $event->delete();
        echo json_encode(array(
            "status" => true,
            "message" => "Event deleted successfully"
        ));
    }
    else{
        $resp=array("responseCode"=>"1000","responseObject"=>"","responseText"=>"unsuccessful","status" =>false);
        echo json_encode($resp);
    }
});


//for rener page
$app->get('/home(/)', $auth(),function () use ($app, $mustache) {
    $app->redirect('events');
//    $page['title'] = "Home";
//    $page['home_active'] = true;
//    echo $mustache->render('_common/header',array('pageInfo' => $page)) . "\n";
//    require_once '../src/views/home.php';
//    echo "\n" . $mustache->render('_common/footer',array('pageInfo' => $page));

});

$app->get('/help', $auth(), function () use ($app, $mustache,$db) {
    $page['title'] = __("Help");
    $page['help_active'] = true;
    echo $mustache->render('_common/header',array('pageInfo' => $page));
    echo $mustache->render('players/help','');
    //include '../src/views/help.php';
    //echo $mustache->render('_common/footer',array('pageInfo' => $page));
});

$app->get('/events', $auth(), function () use ($app, $mustache,$db) {
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

$app->get('/addevent(_(:id(/)))', $auth(), function ($id = null) use ($app, $mustache,$db) {
    $page['title'] = "AddEvents";
    $page['addevent_active'] = true;
    echo $mustache->render('_common/header',array('pageInfo' => $page));
    include '../src/views/addevent.php';
    //echo $mustache->render('_common/footer',array('pageInfo' => $page));
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