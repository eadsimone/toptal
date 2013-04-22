<?php

$slimRequest = $app->request();

if ($slimRequest->isPost()) {
	// Call the service bus to search.
	// TODO: Uncomment this and remove the fake $response object when we're 
	// ready to render pages from service bus calls instead of fake data.
	// $serviceBusRequest = array(
	// 	'apiKey' => '{{publicKey}}',
	// 	'channelPartnerId' => $_SESSION['channelPartnerId'],
	// 	'requestObject' => null,
	// 	'params' => array(
	// 		$slimRequest->post('searchBy') => array(
	// 			$slimRequest->post('searchFor'),
	// 		),
	// 	),
	// );

	// $sb_path = '/api/client/search';
	// $response = json_decode(ServicebusRequest($sb_path, json_encode($serviceBusRequest)));
	$response = new \StdClass;
	$response->responseCode = 1000;
	$response->responseObject = array(
		array(
			'firstName' => 'Ezequiel',
			'lastName' => 'De Simone',
			'storeName' => "Eze's store",
			'email' => 'eze@example.com',
			'channel' => "Eze's channel",
			'clientGuid' => '1234-5678-9012',
		),
		array(
			'firstName' => 'Joe',
			'lastName' => 'Williams',
			'storeName' => "Joe's store",
			'email' => 'joe@example.com',
			'channel' => "Joe's channel",
			'clientGuid' => '12ab-52s8-9bc4',
		),
		array(
			'firstName' => 'Kevin',
			'lastName' => 'Laude',
			'storeName' => "Kevin's store",
			'email' => 'kevin@example.com',
			'channel' => "Kevin's channel",
			'clientGuid' => '1abc-8765-23dc',
		),
	);

	$return = array(
		'searchFor' => $slimRequest->post('searchFor'),

		// This is haskish, but mustache doesn't do logic, so you have to 
		// populate individual variables per search field to see which search by 
		// field to select after form submit. Also, since mustache can't count 
		// objects in a result so tell the template that a form was submitted 
		// and no results were found so it can present a "no results found" 
		// message.
		'searchByBlank' => $slimRequest->post('searchBy') == '' ? ' selected' : '',
		'searchByName' => $slimRequest->post('searchBy') == 'name' ? ' selected' : '',
		'searchByEmail' => $slimRequest->post('searchBy') == 'email' ? ' selected' : '',
		'searchByPlayerGuid' => $slimRequest->post('searchBy') == 'playerGuid' ? ' selected' : '',
		'hasSearchResults' => (count($response->responseObject) > 0),
		'formSubmitted' => true,

		'errorMessage' => $response->responseCode != 1000 ? $response->responseText : '',		
		'searchResults' => $response->responseObject,
	);

	return json_encode($return);
} else {
	// This is hackish, but mustache doesn't have any logic capabilities, so 
	// tell the template that a form wasn't submitted, but supress the "no 
	// results found" message by saying there were results wihtout actually 
	// populating any results.
	return json_encode(array(
		'formSubmitted' => false,
		'hasSearchResults' => true,
	));
}