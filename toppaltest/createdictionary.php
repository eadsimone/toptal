<?php
/**
 * Created by JetBrains PhpStorm.
 * User: joanbellusci
 * Date: 14/03/13
 * Time: 11:21
 * To change this template use File | Settings | File Templates.
 */
if(isset($_GET['folder']) && $_GET['folder'] != '') {
    $__MATCHREG = '/\{\{#i18n\}\}(.+?)\{\{\/i18n\}\}/';

    $folder = $_GET['folder'];

    $route = Array(
        getcwd(),
        'src',
        'views2',
        $folder
    );
    $dir = join(DIRECTORY_SEPARATOR, $route);

    $files = new DirectoryIterator($dir);

    $htmlElements = Array();
    $matches = array();
    foreach ( $files as $file) {
        $fileName = $file->getFilename();

        if(preg_match('/\.html/', $fileName)) {
            $htmlText = file_get_contents($dir.DIRECTORY_SEPARATOR.$fileName);
            preg_match_all($__MATCHREG, $htmlText, $matches);
            foreach ( $matches[1] as $text) {
                $htmlElements[trim($text)] = trim($text);
            }
        }
    }
    foreach ( $htmlElements as $key => $translate) {
        echo '"'.$key.'", "'.$translate."\"<br/>";
    }
}
