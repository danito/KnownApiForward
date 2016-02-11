
<?php
$foo = file_get_contents("php://input");

$request = (json_decode($foo, true));
        //create your secrets
        if (!file_exists('secret.json')){ //put this outside your webserver
                $apikey     = strtolower(substr(base64_encode(generateToken(32)), 12, 16));
                $auth_code  = bin2hex(generateToken(16));
                $secret= array('apikey'=>$apikey, 'auth'=>$auth_code);
                file_put_contents('secret.json',json_encode($secret));
        } else {
                $secret = json_decode(file_get_contents('secret.json'),TRUE);
        }
if (!empty($request['key']) && !empty($request['id'])){
        $known['action']= (!empty($request['action']) ? $request['action'] : "/status/edit";
        $known['username'] = "YOUR_KNOWN_USER";
        $known['secret'] = $secret;
        $known['status'] = json_encode(array("body"=>$request['body']));
        $known['known_api_key'] = "YOUR_KNOWN_API_KEY";
        $known['token'] = base64_encode(hash_hmac('sha256',$known['action'] ,$known['known_api_key'] , true));
        $known['headers'] =   array('Accept: application/json',
                                     'X-KNOWN-USERNAME: ' . $known['username'],
                                     'X-KNOWN-SIGNATURE: ' .$known['token'],
                                     'Content-Type: application/json', 
                                     'Content-Length: ' . strlen($known['status'])); 
if ($request['key'] == $secret['apikey'] && $request['id']) {
$ch = curl_init();
curl_setopt($ch, CURLOPT_COOKIEJAR, "/tmp/cookiefile");
curl_setopt($ch, CURLOPT_URL,"YOUR_KNOWN_SITE_URL".$known['action']);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $known['status']);
curl_setopt($ch, CURLOPT_HTTPHEADER, $known['headers']);                                                                          

$buf2 = curl_exec ($ch);

curl_close ($ch);

        }
                                                                                                  19,65-72      Top
