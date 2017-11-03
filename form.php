<?php

/**
 * Faz a conexão com a Server e retorna um XML de campos
 * @return type
 */
class Form
{

    private $br;
    private $xml;

    /**
     * Abre o form setando os parâmetros necessários
     * @param type $name
     * @param type $id
     * @param type $method
     * @param type $action
     */
    public function formOpen($name = null, $id = null, $method = null, $action = null)
    {
        echo "<form name=\"{$name}\" id=\"{$id}\" method=\"{$method}\" action=\"{$action}\">";
    }

    /**
     * Fecha o form
     */
    public function formClose()
    {
        echo "</form>";
    }

    /**
     * Imprime o campo HTML
     * @param type $formato
     * @param type $tipo
     * @param type $name
     * @param type $indice
     * @param type $label
     * @param type $obrigatorio
     * @param type $opcoes
     * @return type
     */
    public function campo($formato, $tipo, $name, $indice, $label, $obrigatorio, $opcoes)
    {
        $require = $obrigatorio > 0 ? "required=\"true\"" : NULL;
        if ($formato == "input") {
            return "<label for=\"$indice\">{$label}:</label>{$this->br}<input type=\"$tipo\" name=\"$name\" id=\"$indice\" $require>";
        } else {
            $string = "<label for=\"$indice\">{$label}:</label>{$this->br}<select name=\"$name\" id=\"$indice\" $require>";
            foreach ($opcoes as $key => $value):
                $string .= "<option vlue=\"{$key}\">{$value}</option>";
            endforeach;
            return $string .= "</select>";
        }
    }

    /**
     * Insere uma quebra de linha no label
     * @param type $value
     */
    public function setBr($value)
    {
        $this->br = $value > 0 ? '<br/>' : NULL;
    }

    /**
     * Retorna o corpo do xml
     * @return type
     */
    public function getXml()
    {
        return $this->xml;
    }

    /**
     * conecta no webserver e alimenta o artributo xml
     */
    public function connect()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://leads.evolutime.net.br/api/campo/campos?format=xml");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $this->xml = simplexml_load_string($result);
    }

}
