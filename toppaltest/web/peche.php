<?php
$link = mysql_connect('eadesimone.domaincommysql.com', 'usertoptal', 'usert0p');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
echo 'Connected successfully';
mysql_select_db(toppaltest);
?> 