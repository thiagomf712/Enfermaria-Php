<!-- Modal Alerta -->
<div class="modal fade" id="modalAlerta">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning p-2">
                <h5 class="modal-title">Atenção</h5>
            </div>
            <div class="modal-body">
                <p id="modal-conteudo"></p>
            </div>
            <div class="modal-footer p-2">
                <button type="submit" class="btn btn-primary" form="Deletar">Deletar</button>

                <form method="POST" id="Deletar" action="../../Controllers/FuncionarioController.php">
                    <input type="hidden" name="metodoFuncionario" value="Deletar"/>
                    <input type="hidden" name="funcionarioId" value="<?php echo $lista[$index]['Id']; ?>" />   
                    <input type="hidden" name="usuarioId" value="<?php echo $lista[$index]['UsuarioId']; ?>" />
                </form>

                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="history.go(-1);">Fechar</button>
            </div>
        </div>
    </div>
</div>

