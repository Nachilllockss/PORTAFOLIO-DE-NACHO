<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Recopilar los datos del formulario
  $nombre = strip_tags(trim($_POST["name"]));
  $nombre = str_replace(array("\r","\n"),array(" "," "),$nombre);
  $correo = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
  $mensaje = trim($_POST["message"]);

  // Verificar que los datos son válidos
  if (empty($nombre) || empty($mensaje) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    // Los datos no son válidos, regresar al formulario
    http_response_code(400);
    echo "Por favor, llena correctamente el formulario y vuelve a intentarlo.";
    exit;
  }

  // Configurar el destinatario del correo electrónico y el asunto
  $para = "nachillocks@gmail.com";
  $asunto = "Nuevo mensaje de $nombre";

  // Construir el cuerpo del correo electrónico
  $mensajeCorreo = "Nombre: $nombre\n\n";
  $mensajeCorreo .= "Correo electrónico: $correo\n\n";
  $mensajeCorreo .= "Mensaje:\n$mensaje\n";

  // Enviar el correo electrónico
  if (mail($para, $asunto, $mensajeCorreo)) {
    // El correo electrónico fue enviado con éxito
    http_response_code(200);
    echo "¡Gracias! Tu mensaje ha sido enviado.";
  } else {
    // Ocurrió un error al enviar el correo electrónico
    http_response_code(500);
    echo "Oops! Algo salió mal y no pudimos enviar tu mensaje.";
  }

} else {
  // Acceso ilegal al archivo, regresar al formulario
  http_response_code(403);
  echo "Ha ocurrido un error, por favor intenta más tarde.";
}
?>
