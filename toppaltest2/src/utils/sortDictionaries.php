<?php

/*

go though each csv file in the locale directory.
	for each file, take the list and sort it alphabetically by key and save new copy of the file.
	make sure no duplicates exist
	keys are case sensitive, so "Hello world" is different from "hello world"

 */

$dir = '../locale/*';
foreach (glob($dir) as $file) {
    $filename = $file;

    // Sorts the list
    $list = file($filename);

    // Gets rid of the duplicates
    $data = array_map('unserialize', array_unique(array_map('serialize', $list)));

    // Sorts the data
    natcasesort($data);
    sort($data);

    // Saves a new copy of the file with a -new at the end of the filename
    $fp = fopen($filename.'-new', 'w');
    foreach ($data as $key => $value) {
        fwrite($fp, $value);
    }
    fclose($fp);

}