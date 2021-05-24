<?php
$env = array();
include_once(MODX_BASE_PATH.'assets/lib/APIHelpers.class.php');
include_once(MODX_BASE_PATH.'assets/snippets/userEnv/SxGeo/SxGeo.php');
$SxGeo = new SxGeo(MODX_BASE_PATH.'assets/snippets/userEnv/SxGeo/SxGeoCity.dat');
$env['ip'] = \APIHelpers::getUserIP();
$env['browser'] = $_SERVER['HTTP_USER_AGENT'];
if ($geo = $SxGeo->getCityFull($env['ip'])) {
    $env['coords'] = str_replace(',','.',$geo['city']['lat']).','.str_replace(',','.',$geo['city']['lon']);
    $env['city'] = $geo['city']['name_ru'];
    $env['region'] = $geo['region']['name_ru'];
    $env['country'] = $geo['country']['name_ru'];
    $env['country_iso'] = $geo['country']['iso'];
};
if (isset($FormLister)) {
    $FormLister->setFields($env,'env');
} elseif (isset($tpl)) {
    include_once(MODX_BASE_PATH.'assets/snippets/DocLister/lib/DLTemplate.class.php');
    return DLTemplate::getInstance($modx)->parseChunk($tpl,$env);
}