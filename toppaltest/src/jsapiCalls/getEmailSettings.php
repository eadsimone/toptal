<?php
//$json = '{ "orderEmails": "toyin@toyin.org, toyin@cinsay.com"}';

$json =
    '{
        "orderEmails": [
            {
                "email": "toyin@toyin.org",
                "id": "1"
            },
            {
                "email": "toyin@cinsay.com",
                "id": "2"
            }

        ]
    }';

$data = json_decode($json, true);

//$orderEmails = array_map("trim", explode(",", $data['orderEmails']));
$orderEmails = $data;

echo json_encode($orderEmails);
