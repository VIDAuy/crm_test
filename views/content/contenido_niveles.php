<?php if ($_SESSION['nivel'] == 1) { ?>
    <input type="hidden" id="filial" value="<?= $_SESSION['filial'] ?>">
<?php } ?>
<input type="hidden" id="sector" value="<?= ucfirst($_SESSION['usuario']) ?>">
<input type="hidden" id="nivel" value="<?= $_SESSION['nivel'] ?>">
<?php if ($_SESSION['nivel'] != 1) { ?>
    <input type="hidden" id="idrelacion">
<?php } ?>



<div id="contenedor_consultar_cedulas">
</div>


<br>