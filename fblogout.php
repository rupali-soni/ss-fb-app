<?php
session_start();
// Composer autoload
require_once __DIR__ . '/vendor/autoload.php';
$conf = new Config();
$fb = new \Facebook\Facebook([
      'app_id'                => $conf->getConfig('FB_APP_ID'),
      'app_secret'            => $conf->getConfig('FB_SECRET_KEY'),
      'default_graph_version' => 'v2.9'
]);

$helper = $fb->getRedirectLoginHelper();
$siteUrl = $conf->getSiteURL();
$logoutUrl = $helper->getLogoutUrl($_SESSION['fb_access_token'], $siteUrl);
unset($_SESSION['fb_access_token']);
session_destroy();
header('Location: '.$logoutUrl);