<?php
session_start();
require_once __DIR__ . '/../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Por favor, complete todos los campos.";
        header("Location: " . BASE_URL . "index.php");
        exit();
    }
    $response = login($email, $password);
    if (isset($response['code']) && $response['code'] == 2) {
        $_SESSION['user'] = $response['data']['email'];
        $_SESSION['token'] = $response['data']['token'];
        header("Location: " . BASE_URL . "tpm/dashboard/index.php");
        exit();
    } else {
        $_SESSION['error'] = $response['message'] ?? "Credenciales incorrectas.";
        header("Location: " . BASE_URL . "index.php");
        exit();
    }
}

function login($email, $password)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://crud.jonathansoto.mx/api/login',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => http_build_query(array(
            'email' => $email,
            'password' => $password
        )),
    ));
    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        echo 'Error cURL: ' . curl_error($curl);
    }
    curl_close($curl);
    return json_decode($response, true);
}
?>
