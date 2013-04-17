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



$app->get('/internal_api/:action/:object(/(:guid(/(:isRaw(/)))))',
    function ($action, $object, $guid = null, $isRaw = false) use ($app, $mustache) {

        if($isRaw != "raw") {
            $isRaw = false;
        } else {
            $isRaw = true;
        }

        echo "action: " . $action . "<br>\n";
        echo "object: " . $object . "<br>\n";
        echo $object."Guid: " . $guid . "<br>\n";

        echo "isRaw: " . $isRaw . "<br>\n";

// 	$Object = "\\Fiji\\SbService\\".ucwords($object);
// 	$sb = new $Object($action, null);
// 	echo $app->json($sb->json);

    });

$app->get('/views/:folder/:file', function ($folder = null, $file = null) use ($app) {
    echo file_get_contents("../src/views/" . $folder . "/" . $file);
});

$app->get('/video(_(:videoGuid(/)))', $auth(), function ($videoGuid = null) use ($app, $mustache) {
    if($videoGuid == null) {
        $app->redirect('players');
    } else {
        $page['title'] = __("Video");
        $page['subhead'] = __("Edit Video: ") . $videoGuid;
        $page['video_active'] = true;
        $page['userEmail'] = $_SESSION['SSMData']['userEmail'];
        echo $mustache->render('_common/header',array('pageInfo' => $page));
        include '../src/views/video.php';
        echo $mustache->render('_common/footer',array('pageInfo' => $page));
    }
});
$app->get('/product(_(:productGuid(/)))', $auth(), function ($productGuid = null) use ($app, $mustache) {
    if($productGuid == null) {
        $app->redirect('players');
    } else {
        $page['title'] = __("Player");
        $page['subhead'] = __("Edit Product: ") . $productGuid;
        $page['product_active'] = true;
        $page['userEmail'] = $_SESSION['SSMData']['userEmail'];
        echo $mustache->render('_common/header',array('pageInfo' => $page));
        include '../src/views/product.php';
        //echo "playerGuid: " . $playerGuid;
        echo $mustache->render('_common/footer',array('pageInfo' => $page));
    }
});





$app->get('/player(_(:playerGuid(/)))', $auth(), function ($playerGuid = null) use ($app, $mustache) {
    if($playerGuid == null) {
        $app->redirect('players');
    } else {
//		$page['title'] = __("Players");
//        $page['linktitle'] = "players";
//		$page['subhead'] = __("Loading Player...");
//		$page['players_active'] = true;
//        $_SESSION['SSMData']['playerGuid']= $playerGuid;
//        $page['userEmail'] = $_SESSION['SSMData']['userEmail'];
        echo $mustache->render('_common/header',array('pageInfo' => $page));
        include '../src/views/player.php';
        //echo "playerGuid: " . $playerGuid;
        echo $mustache->render('_common/footer',array('pageInfo' => $page));
    }
});



$app->get('/players(/)', $auth(), function () use ($app, $mustache) {
    $page['title'] = __("Events");

    echo $mustache->render('_common/header',array('pageInfo' => $page));
    include '../src/views/players.php';
    //echo $mustache->render('_common/footer',array('pageInfo' => $page));
});



$app->get('/account(/)', $auth(), function () use ($app, $mustache) {
    $page['title'] = __("Account");
    $page['linktitle'] = "account";
    $page['subhead'] = __("Account Information");
    $page['account_active'] = true;
    $page['userEmail'] = $_SESSION['SSMData']['userEmail'];
    echo $mustache->render('_common/header',array('pageInfo' => $page));
    include '../src/views/account.php';
    echo $mustache->render('_common/footer',array('pageInfo' => $page));
});



$app->get('/reports(/)', $auth(), function () use ($app, $mustache) {
    $page['title'] = __("Reports");
    $page['report_active'] = true;
    $page['userEmail'] = $_SESSION['SSMData']['userEmail'];
    echo $mustache->render('_common/header',array('pageInfo' => $page)) . "\n";
    require_once '../src/views/reports.php';
    echo "\n" . $mustache->render('_common/footer',array('pageInfo' => $page));
});



$app->get('/orders(/)', $auth(), function () use ($app, $mustache) {
    $page['title'] = __("Orders");
    $page['orders_active'] = true;
    $page['userEmail'] = $_SESSION['SSMData']['userEmail'];
    echo $mustache->render('_common/header',array('pageInfo' => $page)) . "\n";
    echo '<div class="main-content"><h2>Orders Page</h2>nothing to see here<br><br></div>';
    echo "\n" . $mustache->render('_common/footer',array('pageInfo' => $page));
});



$app->get('/store_settings(/)', $auth(), function () use ($app, $mustache) {
    $page['title'] = __("Store Settings");
    $page['store_settings_active'] = true;
    $page['userEmail'] = $_SESSION['SSMData']['userEmail'];
    echo $mustache->render('_common/header',array('pageInfo' => $page)) . "\n";
    require_once '../src/views/store.php';
    echo "\n" . $mustache->render('_common/footer',array('pageInfo' => $page));
});



$app->get('/stats(/)', $auth(), function () use ($app, $mustache) {
    $page['title'] = __("Stats");
    $page['stats_active'] = true;
    $page['userEmail'] = $_SESSION['SSMData']['userEmail'];
    echo $mustache->render('_common/header',array('pageInfo' => $page)) . "\n";
    require_once '../src/views/stats.php';
    echo "\n" . $mustache->render('_common/footer',array('pageInfo' => $page));
});



$app->get('/home(/)', $auth(), function () use ($app, $mustache) {
    $page['title'] = __("Home");
    $page['home_active'] = true;
    $page['userEmail'] = $_SESSION['SSMData']['userEmail'];
    echo $mustache->render('_common/header',array('pageInfo' => $page)) . "\n";
    require_once '../src/views/home.php';
    echo "\n" . $mustache->render('_common/footer',array('pageInfo' => $page));
})->name('home');



$app->map('/formHandler(/(:formType))', function ($formType = null) use ($app) {
    $handlers = array(
        'savePlayerHandler','saveVideoHandler','saveProductHandler',
        'saveClientInfoHandler','upgradePlanHandler','shareEmailHandler',
        'loginHandler', 'passwordHandler'
    );
    if(!in_array($formType . "Handler", $handlers)) {
        echo __("INVALID HANDLER . . redirecting");
        //$app->redirect("../home");
    } else {
        //echo $formType . " handler";
        include '../src/jsapiCalls/' . $formType . 'Handler.php';
    }
})->via('GET', 'POST');;

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




$app->get('/buzz', function () use ($app) {
    $startTime = time();

    $url = "http://services.int.cinsay.com/api/cms/players/get";
    $orig_data = '{"apiKey":"cinsay99Public","clientId":"7973","requestObject":null,"params":null}';

    $data = encodeForServiceBus($orig_data, "cinsay99Private");

    $config = getAppConfig();
    $httpclient = $config['httpclient'];
    $response = $httpclient->post($url, array('Content-type: application/json; charset=UTF-8'), $data);

    echo "<pre>" . prettyJSON($response->getContent()) . "</pre>\n";

    echo "\n" . time() - $startTime . " seconds";
});


$app->get('/servicebuslog', $auth(), function () use ($app, $mustache) {
    $page['title'] = __("Service Bus Log");
    $page['userEmail'] = $_SESSION['SSMData']['userEmail'];

    echo $mustache->render('_common/header',array('pageInfo' => $page, 'blank' => true)) . "\n";
    include '../src/views/servicebuslog.php';
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

$app->get('(/:lang)/summary/', function ($lang = null) use ($app, $localeLoockup) {
    if ($lang === null) {
        $lang = getenv('CINSAY_DEFAULT_LANG');
        if (gettype($lang) !== 'string') {
            $lang = 'en';
        }
    }

    if (array_key_exists($lang, $localeLoockup)) {
        $locale = $localeLoockup[$lang];

        $app->render('dashboard.php', array(
            'currentLocale' => $locale,
            'translator' => new \Localization\Translator($locale),
            'currency' => new \Localization\Currency($locale),
            'serviceBus' => new \ServiceBus\ServiceBus(),
            'currentTab' => 'summary',
            'tooltipsEnabled' => getenv('CINSAY_TOOLTIPS') === 'on'
        ));
    } else {
        $app->notFound();
    }
});

$app->get('(/:lang)/attract/', function ($lang = null) use ($app, $localeLoockup) {
    if ($lang === null) {
        $lang = getenv('CINSAY_DEFAULT_LANG');
        if (gettype($lang) !== 'string') {
            $lang = 'en';
        }
    }

    if (array_key_exists($lang, $localeLoockup)) {
        $locale = $localeLoockup[$lang];

        $app->render('dashboard.php', array(
            'currentLocale' => $locale,
            'translator' => new \Localization\Translator($locale),
            'currency' => new \Localization\Currency($locale),
            'serviceBus' => new \ServiceBus\ServiceBus(),
            'currentTab' => 'attract',
            'tooltipsEnabled' => getenv('CINSAY_TOOLTIPS') === 'on'
        ));
    } else {
        $app->notFound();
    }
});

$app->get('(/:lang)/interact/', function ($lang = null) use ($app, $localeLoockup) {
    if ($lang === null) {
        $lang = getenv('CINSAY_DEFAULT_LANG');
        if (gettype($lang) !== 'string') {
            $lang = 'en';
        }
    }

    if (array_key_exists($lang, $localeLoockup)) {
        $locale = $localeLoockup[$lang];

        $app->render('dashboard.php', array(
            'currentLocale' => $locale,
            'translator' => new \Localization\Translator($locale),
            'currency' => new \Localization\Currency($locale),
            'serviceBus' => new \ServiceBus\ServiceBus(),
            'currentTab' => 'interact',
            'tooltipsEnabled' => getenv('CINSAY_TOOLTIPS') === 'on'
        ));
    } else {
        $app->notFound();
    }
});

$app->get('(/:lang)/transact/', function ($lang = null) use ($app, $localeLoockup) {
    if ($lang === null) {
        $lang = getenv('CINSAY_DEFAULT_LANG');
        if (gettype($lang) !== 'string') {
            $lang = 'en';
        }
    }

    if (array_key_exists($lang, $localeLoockup)) {
        $locale = $localeLoockup[$lang];

        $app->render('dashboard.php', array(
            'currentLocale' => $locale,
            'translator' => new \Localization\Translator($locale),
            'currency' => new \Localization\Currency($locale),
            'serviceBus' => new \ServiceBus\ServiceBus(),
            'currentTab' => 'transact',
            'tooltipsEnabled' => getenv('CINSAY_TOOLTIPS') === 'on'
        ));
    } else {
        $app->notFound();
    }
});

/*** Routes for services ******************************************************/

$app->get('/api/tab/:tab/players/:players/from/:from/to/:to/', function ($tab, $players, $from, $to) {
    $serviceBus = new \ServiceBus\ServiceBus();
    echo $serviceBus->getAnalyticsData($tab, $players, $from, $to);
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