<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head lang="pt-br">
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            include 'models\Pessoa.php';
        
            $pessoa = new Pessoa(1, "João");
            echo $pessoa->getNome();
        ?>
    </body>
</html>
