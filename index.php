<?php

$filtro = array('nome', 'email', 'telefone', 'time', 'profissionalizantes');

require_once 'Form.php';
require_once 'Post.php';

if (@$_POST) {
    $post = new Post;
    if ($post->connect($_POST['nome'], $_POST['email'])) {
        echo "Cadastro realizado com sucesso!";
        return false;
    } else {
        echo "erro: tente novamente...";
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
        echo $form->campo($value->item->formato, $value->item->tipo, $value->item->name, $value->item->indice, $value->item->label, $value->item->obrigatorio, $opcoes);
        echo "<br>";
    }
endforeach;
echo "<br>";
echo "<input type=\"submit\" value=\"Cadastrar\" />";

# fecha o form
$form->formClose();
