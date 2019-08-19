<script src="https://kit.fontawesome.com/f3a7ec9ee6.js"></script>

<?php if (count($lista) > 25) : ?>
    <form method="GET">
        <div class="d-flex flex-wrap">
            <!-- Retornar pagina --> 
            <?php if ($paginaAtual > 1) : ?>
                <div class="mt-1 mr-2">
                    <button class="btn btn-secondary" type="submit" onclick="document.getElementById('pagina').value = <?php echo $paginaAtual; ?> - 1"><i class="fas fa-arrow-left"></i></button> 
                </div>
            <?php endif; ?>

            <!-- Select de paginas --> 
            <div class="mt-1 mr-2">
                <select class="custom-select" name="pagina" id="pagina">
                    <?php for ($i = 1; $i <= $numeroPaginas; $i++) : ?>
                        <option value="<?php echo $i; ?>" <?php echo ($i == $paginaAtual) ? 'selected' : ''; ?>><?php echo 'Pagina ' . $i; ?></option>
                    <?php endfor; ?>
                </select>
            </div>

            <!-- Ir para pagina selecionada --> 
            <div class="mt-1 mr-2">
                <input class="btn btn-secondary" type="submit" value="Ir" />  
            </div>

            <!-- Avançar pagina -->
            <?php if ($paginaAtual < $numeroPaginas) : ?>    
                <div class="mt-1">
                    <button class="btn btn-secondary" type="submit" onclick="document.getElementById('pagina').value = <?php echo $paginaAtual; ?> + 1"><i class="fas fa-arrow-right"></i></button> 
                </div>
            <?php endif; ?>
        </div>
    </form>
<?php endif; ?>