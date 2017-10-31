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

    private $br;

    public function campo($formato, $tipo, $id, $name, $indice, $label, $opcoes)
    {
        if ($formato == "input") {
            return "<label for=\"$indice\">{$label}:{$this->br}<input type=\"$tipo\" name=\"$name\" id=\"$indice\"></label>";
        } else {
            $string = "<label for=\"$indice\">{$label}:{$this->br}<select name=\"$name\" id=\"$indice\">";
            foreach ($opcoes as $key => $value):
                $string .= "<option vlue=\"{$key}\">{$value}</option>";
            endforeach;
            return $string .= "</select></label>";
        }
    }

    public function setBr($value)
    {
        $this->br = $value > 0 ? '<br/>' : NULL;
    }

}

$form = new Form;
$form->setBr(true);
$xml = get_curl();

$input = array('nome', 'signo', 'email', 'telefone', 'curso', 'time', 'profissionalizantes');

# formato {input/select}
# tipo {email, number, password...}
foreach ($xml as $value):
    # verifica se pode ser impresso
    if (in_array($value->item->name, $input)) {
        # gera as opções
        $opcoes = array();
        foreach ($value->item[1]->opcoes->opco as $item):
            $opcoes[(int) $item->id] = $item->value;
        endforeach;
        echo $form->campo($value->item->formato, $value->item->tipo, $value->item->id, $value->item->name, $value->item->indice, $value->item->label, $opcoes);
        echo "<br>";
    }
endforeach;

//echo "<pre>";
//print_r(get_curl());
//echo "</pre>";
