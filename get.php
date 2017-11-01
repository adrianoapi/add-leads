<?php

/**
 * Faz a conexão com a Server e retorna um XML de campos
 * @return type
 */
class Form
{

    private $br;
    private $xml;

    public function campo($formato, $tipo, $id, $name, $indice, $label, $obrigatorio, $opcoes)
    {
        $require = $obrigatorio > 0 ? "required=\"true\"" : NULL;
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
    
    public function getXml(){
        return $this->xml;
    }

    public function connect()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://leads.evolutime.net.br/api/campo/campos?format=xml");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $this->xml =  simplexml_load_string($result);
    }

}

$form = new Form;
$form->connect();
$form->setBr(true);

$filtro = array('nome', 'signo', 'email', 'telefone', 'curso', 'time', 'profissionalizantes');

# formato {input/select}
# tipo {email, number, password...}
foreach ($form->getXml() as $value):
    # verifica se pode ser impresso
    if (in_array($value->item->name, $filtro)) {
        # gera as opções
        $opcoes = array();
        foreach ($value->item[1]->opcoes->opco as $item):
            $opcoes[(int) $item->id] = $item->value;
        endforeach;
        echo $form->campo($value->item->formato, $value->item->tipo, $value->item->id, $value->item->name, $value->item->indice, $value->item->label, $value->item->obrigatorio, $opcoes);
        echo "<br>";
    }
endforeach;

//echo "<pre>";
//print_r(get_curl());
//echo "</pre>";
