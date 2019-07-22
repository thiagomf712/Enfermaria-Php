<script src="https://kit.fontawesome.com/f3a7ec9ee6.js"></script>

<?php if (count($lista) > 25) : ?>
    <form method="GET" class="form-inline">    
        <?php if ($paginaAtual > 1) : ?>
            <button class="btn btn-primary mr-2" type="submit" onclick="document.getElementById('pagina').value = <?php echo $paginaAtual; ?> - 1"><i class="fas fa-arrow-left"></i></button> 
        <?php endif; ?>

        <select class="custom-select my-1 mr-2" name="pagina" id="pagina">
            <?php for ($i = 1; $i <= $numeroPaginas; $i++) : ?>
                <option value="<?php echo $i; ?>" <?php echo ($i == $paginaAtual) ? 'selected' : ''; ?>><?php echo 'Pagina ' . $i; ?></option>
            <?php endfor; ?>
        </select>

        <input class="btn btn-primary mr-2" type="submit" value="Ir" />  

        <?php if ($paginaAtual < $numeroPaginas) : ?>
            <button class="btn btn-primary" type="submit" onclick="document.getElementById('pagina').value = <?php echo $paginaAtual; ?> + 1"><i class="fas fa-arrow-right"></i></button> 
            <?php endif; ?>
    </form>
<?php endif; ?>