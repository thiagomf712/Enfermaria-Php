<?php if (isset($_SESSION['erro']) || isset($_SESSION['sucesso'])) : ?>
    <script>
        $(document).ready(function () {
            $("#modal").modal();
        });
    </script>
<?php endif; ?>

<div class="modal fade" id="modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header <?php echo (isset($_SESSION['erro'])) ? 'bg-danger' : 'bg-success'; ?> p-2">
                <h5 class="modal-title"><?php echo (isset($_SESSION['erro'])) ? 'Erro' : 'Sucesso'; ?></h5>
            </div>
            <div class="modal-body">
                <p>
                    <?php
                    if (isset($_SESSION['erro'])) {
                        echo $_SESSION['erro'];
                        unset($_SESSION['erro']);
                    } else {
                        echo $_SESSION['sucesso'];
                        unset($_SESSION['sucesso']);
                    }
                    ?>
                </p>
            </div>
            <div class="modal-footer p-2">
                <button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
