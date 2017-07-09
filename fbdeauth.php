<?php
// Composer autoload
require_once __DIR__ . '/vendor/autoload.php';
$conf = new Config();
$dbModel = new Dbmodel();

function parse_signed_request($signed_request) {
  list($encoded_sig, $payload) = explode('.', $signed_request, 2); 

  $secret = $conf->getConfig('FB_SECRET_KEY'); // Use your app secret here

  // decode the data
  $sig = base64_url_decode($encoded_sig);
  $data = json_decode(base64_url_decode($payload), true);

  // confirm the signature
  $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
  if ($sig !== $expected_sig) {
    error_log('Bad Signed JSON signature!');
    return null;
  }

  return $data;
}

function base64_url_decode($input) {
  return base64_decode(strtr($input, '-_', '+/'));
}

$data = parse_signed_request($_POST['signed_request']);
$data = array(
      "fb_id"         => $data['user_id'],
      "is_active"     => 0
);
$dbModel->updateUser($data, 1);