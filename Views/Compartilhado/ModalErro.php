<?php if (isset($_SESSION['erro'])) : ?>
    <script>
        $(document).ready(function () {
            $("#modal").modal();
        });
    </script>
<?php endif; ?>

<!-- Modal Branco -->
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-secondary">
            <div class="modal-header bg-danger p-2">
                <h5 class="modal-title">Erro</h5>
            </div>
            <div class="modal-body text-black">
                <p>
                    <?php
                    echo $_SESSION['erro'];
                    unset($_SESSION['erro']);
                    ?>
                </p>
            </div>
            <div class="modal-footer p-2">
                <button type="button" class="btn btn-primary btn-block" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

