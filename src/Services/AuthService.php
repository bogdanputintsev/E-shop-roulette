<?php


namespace App\Services;


class AuthService
{

    public function parseToken($clientid, $clientsecret, $code, $redirect)
    {
        ini_set('allow_url_fopen', '1');
        return json_decode($this->file_content('https://oauth.vk.com/access_token?client_id='.$clientid.'&client_secret='.$clientsecret.'&code='.$code.'&redirect_uri='.$redirect));
    }

    public function parseUser($token)
    {
        if(isset($token->access_token))
        {
            $params = [
                'uids' => $token->user_id,
                'fields' => 'uid, first_name, last_name, photo_50',
                'access_token' => $token->access_token,
                'v' => 5.73
            ];

            return json_decode($this->file_content('https://api.vk.com/method/users.get?' . http_build_query($params)));
        }
        return null;
    }

    private function file_content(string $url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public function getIP()
    {
        if( $this->get('session')->get('ip') == "" )
        {
            if ( !empty ($_SERVER['HTTP_CLIENT_IP'] )) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } else if ( !empty($_SERVER['HTTP_X_FORWARDED_FOR'] )) {
                $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip=$_SERVER['REMOTE_ADDR'];
            }
            $this->get('session')->set('ip', ip2long($ip));
        }
        return $this->get('session')->get('ip');
    }
}