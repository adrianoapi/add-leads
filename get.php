<?php

/**
 * Faz a conexão com a Server e retorna um XML de campos
 * @return type
 */
function get_curl()
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://leads.evolutime.net.br/api/campo/campos?format=xml");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    return simplexml_load_string($result);
}

class Form
{

    public function campo($formato, $tipo, $id, $name, $indice, $opcoes)
    {
        if ($formato == "input") {
            return "<input type=\"$tipo\" name=\"$name\" id=\"$indice\">";
        } else {
            $string = "<select name=\"$name\" id=\"$indice\">";
            foreach ($opcoes as $key => $value):
                $string .= "<option vlue=\"{$key}\">{$value}</option>";
            endforeach;
            return $string .= "</select>";
        }
    }

}

$form = new Form;
$xml = get_curl();

$input = array('nome', 'signo', 'email', 'telefone', 'curso', 'time');

# formato {input/select}
# tipo {email, number, telphone...}
foreach ($xml as $value):
    if (in_array($value->item->name, $input)) {
        $opcoes = array();
        foreach ($value->item[1]->opcoes->opco as $item):
            $opcoes[(int) $item->id] = $item->value;
        endforeach;
        echo $form->campo($value->item->formato, $value->item->tipo, $value->item->id, $value->item->name, $value->item->indice, $opcoes);
        echo "<br>";
    }
endforeach;

//echo "<pre>";
//print_r(get_curl());
//echo "</pre>";
