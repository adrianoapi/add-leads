<?php

/*
 * Filtro do que deve ser exibido
 */
$filtro = array('nome', 'email', 'telefone', 'time', 'profissionalizantes');

/*
 * Include de classes
 */
require_once 'Form.php';
require_once 'Post.php';

if (@$_POST) {
    $post = new Post;
    $result = $post->connect($_POST['nome'], $_POST['email']);
    if (is_numeric($result)) {
        echo "Cadastro realizado com sucesso!";
        return false;
    } else {
        echo "<h1>erro: Ocorreu um erro ao registrar o cadastro.</h1><p>Tente novamente...</p>";
        echo "<pre>";
        print_r($result);
        echo "</pre>";
    }
}


$form = new Form;
$form->connect();
$form->setBr(true);

# inicia o form
$form->formOpen(NULL, "form_leads", "POST", NULL);

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
        echo $form->campo($value->item->formato, $value->item->tipo, $value->item->name, $value->item->indice, $value->item->class, $value->item->label, $value->item->obrigatorio, $opcoes);
        echo "<br>";
    }
endforeach;
echo "<br>";
echo "<input type=\"submit\" value=\"Cadastrar\" />";

# fecha o form
$form->formClose();
