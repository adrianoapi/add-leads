<?php

function teste_curl($new_name, $new_email)
{
    $username = 'admin';
    $password = '1234';

    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, 'http://leads.evolutime.net.br/api/cadastro/user');
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_handle, CURLOPT_POST, 1);
    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array(
        'token' => "XNSS-HSJW-3NGU-8XTJ",
        'unidade' => 13,
        'operador' => 0,
        'campanha' => 3,
        'nome' => $new_name,
        'email' => $new_email
    ));

    curl_setopt($curl_handle, CURLOPT_USERPWD, $username . ':' . $password);

    $result = curl_exec($curl_handle);
    curl_close($curl_handle);

    return $result;
}

print_r(teste_curl("adriano", "sdcomputadores@gmail.com"));
