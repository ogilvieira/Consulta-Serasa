<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<p>Consulta CPF Simples</p>
<form id="formulario" name="formulario" method="post" action="consultacpf_php_complex.php">
  <p>
    <label for="cpf">CPF</label>
    <input type="text" name="cpf" id="cpf" />
  </p>
  <p>
    <input type="submit" name="enviar" id="enviar" value="Enviar" />
    <input name="tipoconsulta" type="hidden" id="tipoconsulta" value="ConsultaSimplesSERASA" />
  </p>
</form>
<p>&nbsp;</p>
</body>
</html>