<?php

class Post
{

    public function connect($new_name, $new_email)
    {

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, 'http://leads.evolutime.net.br/api/cadastro/user');
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_POST, 1);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array(
            'token' => "XNSS-HSJW-3NGU-8XTJd",
            'unidade' => 13,
            'operador' => 0,
            'campanha' => 3,
            'nome' => $new_name,
            'email' => $new_email
        ));

        $result = curl_exec($curl_handle);
        curl_close($curl_handle);

        return $result;
    }

}

//print_r(put_curl("adriano", "sdcomputadores@gmail.com"));
