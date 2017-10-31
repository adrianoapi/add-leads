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

    public function campo($formato, $tipo, $id, $name, $indice, $label, $opcoes)
    {
        if ($formato == "input") {
            return "<label for=\"$indice\">$label<br><input type=\"$tipo\" name=\"$name\" id=\"$indice\"></label>";
        } else {
            $string = "<label for=\"$indice\">$label<br><select name=\"$name\" id=\"$indice\">";
            foreach ($opcoes as $key => $value):
                $string .= "<option vlue=\"{$key}\">{$value}</option>";
            endforeach;
            return $string .= "</select></label>";
        }
    }

}

$form = new Form;
$xml = get_curl();

$input = array('nome', 'signo', 'email', 'telefone', 'curso', 'time');

# formato {input/select}
# tipo {email, number, telphone...}
foreach ($xml as $value):
    # verifica se pode ser impresso
    if (in_array($value->item->name, $input)) {
        # gera as opções
        $opcoes = array();
        foreach ($value->item[1]->opcoes->opco as $item):
            $opcoes[(int) $item->id] = $item->value;
        endforeach;
        echo $form->campo($value->item->formato, $value->item->tipo, $value->item->id, $value->item->name, $value->item->indice, $value->item->indice, $opcoes);
        echo "<br>";
    }
endforeach;

//echo "<pre>";
//print_r(get_curl());
//echo "</pre>";
