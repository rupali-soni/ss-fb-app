<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
$conf = new Config();
$fb = new \Facebook\Facebook([
      'app_id'                => $conf->getConfig('FB_APP_ID'),
      'app_secret'            => $conf->getConfig('FB_SECRET_KEY'),
      'default_graph_version' => 'v2.2'
]);
$helper = $fb->getRedirectLoginHelper();
try {
  if (isset($_SESSION['fb_access_token'])) {
    $accessToken = $_SESSION['fb_access_token'];
  } else {
      $accessToken = $helper->getAccessToken();
  }
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (! isset($accessToken)) {
  $permissions = ['email', 'public_profile'];
  $siteUrl = $conf->getSiteURL() . 'fblogin.php';
  $loginUrl = $helper->getLoginUrl($siteUrl, $permissions);
  header("Location: $loginUrl");
}

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();
if(!is_string($accessToken))
  if (! $accessToken->isLongLived()) {
    // Exchanges a short-lived access token for a long-lived one
    try {
      $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
      echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
      exit;
    }
    //echo '<h3>Long-lived</h3>';
    //var_dump($accessToken->getValue()); die;
  }

  $_SESSION['fb_access_token'] = (string) $accessToken;

try {
  // Get the \Facebook\GraphNodes\GraphUser object for the current user.
  // If you provided a 'default_access_token', the '{access-token}' is optional.
  $response = $fb->get('/me?fields=name,first_name,last_name,email', $accessToken);
} catch(\Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(\Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$me = $response->getGraphUser();
$dbModel = new Dbmodel();
$fbId = $me->getId();
$userData = $dbModel->getUser($fbId);
$data = array(
      "fb_id"         => $fbId,
      "first_name"    => $me->getFirstName(),
      "last_name"     => $me->getLastName(),
      "is_active"     => 1,
      "access_token"  => $accessToken
  );
if(!$userData) {
  //Insert userdata in database
  $dbModel->saveUser($data);
} else {
  //Update user data
  $dbModel->updateUser($data);
}
$_SESSION["user"] = $data;
header("Location: index.php");