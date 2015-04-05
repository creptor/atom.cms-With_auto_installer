<?php
include('../config/setup.php');
  // Crea un token de estado para evitar las solicitudes falsas.
  // Guárdalo en la sesión para su validación posterior.
  $state = md5(rand());
  $client['session']->set('state', $state);
  // Determina el ID de cliente, el estado de token y el nombre de la aplicación en el HTML
  // a la hora de servirlo.
  return $client['twig']->render('index.php', array(
      'CLIENT_ID' => CLIENT_ID,
      'STATE' => $state,
      'APPLICATION_NAME' => APPLICATION_NAME
  ));
  // Garantiza que no hay falsas solicitudes y que el usuario
  // que nos envía esta solicitud de conexión es el usuario correcto.
  if ($request->get('state') != ($client['session']->get('state'))) {
    return new Response('Invalid state parameter', 401);
  }
  $code = $request->getContent();
  $gPlusId = $request->get['gplus_id'];
  // Intercambia el código de autorización de OAuth 2.0 por credenciales de usuario.
  $client->authenticate($code);

  $token = json_decode($client->getAccessToken());
  // Verifica el token
  $reqUrl = 'https://www.googleapis.com/oauth2/v1/tokeninfo?access_token=' .
          $token->access_token;
  $req = new Google_HttpRequest($reqUrl);

  $tokenInfo = json_decode(
      $client::getIo()->authenticatedRequest($req)->getResponseBody());

  // Si ha habido un error en la información del token, anula la operación.
  if ($tokenInfo->error) {
    return new Response($tokenInfo->error, 500);
  }
  // Asegúrate de que el token que hemos obtenido es para el usuario deseado.
  if ($tokenInfo->userid != $gPlusId) {
    return new Response(
        "Token's user ID doesn't match given user ID", 401);
  }
  // Asegúrate de que el token que hemos obtenido es para nuestra aplicación.
  if ($tokenInfo->audience != CLIENT_ID) {
    return new Response(
        "Token's client ID does not match app's.", 401);
  }

  // Almacena el token en la sesión para utilizarlo más adelante.
  $client['session']->set('token', json_encode($token));
  $response = 'Succesfully connected with token: ' . print_r($token, true);
?>