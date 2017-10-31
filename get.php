<?php

function get_curl()
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://leads.evolutime.net.br/api/campo/campos?format=xml");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    return simplexml_load_string($result);
}

$xml = get_curl();

$input = array('nome', 'signo','email','telefone','curso','time');

foreach ($xml as $value):
    if (in_array($value->item->name, $input)) {
        echo "{$value->item->id}, {$value->item->name}";
        foreach ($value->item[1]->opcoes->opco as $item):
            echo "{$item->id} - $item->value ,";
        endforeach;
        echo "<br>";
    }
endforeach;

//echo "<pre>";
//print_r(get_curl());
//echo "</pre>";
