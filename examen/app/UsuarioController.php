<?php
class UsuarioController
{
    private $apiUrl = "https://crud.jonathansoto.mx/api/users";
    private $token = '1649|s6uuE6GJv0GuEp5RF4fMvUatQzfsbEZDCtg1Japp';

    public function createUser($name, $lastname, $email, $phone_number, $password, $role, $profile_photo)
    {
        $curl = curl_init();
        $data = [
            'name' => $name,
            'lastname' => $lastname,
            'email' => $email,
            'phone_number' => $phone_number,
            'password' => $password,
            'role' => $role,
            'profile_photo_file' => new CURLFILE($profile_photo),
        ];

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer $this->token",
                "Accept: application/json"
            ],
        ]);

        $response = curl_exec($curl);

        // Manejo de errores
        if (curl_errno($curl)) {
            echo "cURL Error: " . curl_error($curl);
        }

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return $httpCode === 200 ? json_decode($response, true) : false;
    }

    public function obtenerUsuarios()
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer $this->token",
                "Accept: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return $httpCode === 200 ? json_decode($response, true) : false;
    }

    public function obtenerDetalleUsuario($id)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiUrl . '/' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer $this->token",
                "Accept: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return $httpCode === 200 ? json_decode($response, true) : false;
    }

    public function editarUsuario($id, $data)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiUrl . '/' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->token,
                'Content-Type: application/x-www-form-urlencoded'
            ],
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return $httpCode === 200 ? json_decode($response, true) : false;
    }

    public function eliminarUsuario($id)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiUrl . '/' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer $this->token",
                "Accept: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return $httpCode === 200;
    }
}

if (isset($_GET['action'])) {
    $usuarioController = new UsuarioController();

    switch ($_GET['action']) {
        case 'create':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = $_POST['name'];
                $lastname = $_POST['lastname'];
                $email = $_POST['email'];
                $phone_number = $_POST['phone_number'];
                $password = $_POST['password'];
                $role = $_POST['role'];
                $profile_photo = $_FILES['profile_photo']['tmp_name'];

                if ($usuarioController->createUser($name, $lastname, $email, $phone_number, $password, $role, $profile_photo)) {
                    header("Location: ../tpm/application/lista_usuarios.php");
                } else {
                    echo "Error al crear el usuario.";
                }
            }
            break;

        case 'update':
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
                $id = $_POST['id'];
                $data = [
                    'name' => $_POST['name'],
                    'lastname' => $_POST['lastname'],
                    'email' => $_POST['email'],
                    'phone_number' => $_POST['phone_number'],
                    'role' => $_POST['role'],
                    'password' => $_POST['password']
                ];

                if ($usuarioController->editarUsuario($id, $data)) {
                    header("Location: ../tpm/application/lista_usuarios.php");
                } else {
                    echo "Error al actualizar el usuario.";
                }
            }
            break;

        case 'delete':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                if ($usuarioController->eliminarUsuario($id)) {
                    header("Location: ../tpm/application/lista_usuarios.php");
                } else {
                    echo "Error al eliminar el usuario.";
                }
            }
            break;

        default:
            echo "Acción no válida.";
            break;
    }
}
?>
