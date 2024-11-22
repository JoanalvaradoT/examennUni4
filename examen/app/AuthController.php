<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');

    if (!$email || empty($password)) {
        $_SESSION['error'] = "Correo electrónico o contraseña inválidos.";
        header("Location: /unidad4/examen/index.php");
        exit();
    }

    $response = login($email, $password);

    if ($response === null || !isset($response['code'])) {
        $_SESSION['error'] = "No se pudo procesar la solicitud. Intente más tarde.";
        header("Location: /unidad4/examen/index.php");
        exit();
    }

    if ($response['code'] == 2) {
        $_SESSION['user'] = $response['data']['email'];
        $_SESSION['token'] = $response['data']['token'];
        header("Location: /unidad4/examen/tpm/dashboard/index.php");
        exit();
    } else {
        $_SESSION['error'] = $response['message'] ?? "Credenciales incorrectas.";
        header("Location: /unidad4/examen/index.php");
        exit();
    }
}

function login($email, $password)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/login',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => http_build_query(array(
            'email' => $email,
            'password' => $password
        )),
    ));

    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        $_SESSION['error'] = 'Error cURL: ' . curl_error($curl);
        curl_close($curl);
        header("Location: /unidad4/examen/index.php");
        exit();
    }

    curl_close($curl);
    return json_decode($response, true);
}
