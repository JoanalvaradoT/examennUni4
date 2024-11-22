<?php

class ClienteController {

    private $apiUrl = 'https://crud.jonathansoto.mx/api/clients';
    private $token = '1608|jTz8bexkQBEvLarWHbogitucUQqVn2FICow6j9ao';

    public function crearCliente($name, $email, $password, $phone_number) {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'phone_number' => $phone_number
            ]),
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->token,
                'Content-Type: application/json',
                'Accept: application/json'
            ]
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return $httpCode == 200 ? "Cliente creado con éxito." : "Error al crear el cliente. Código: $httpCode Respuesta: $response";
    }

    public function obtenerClientes() {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->token,
                'Accept: application/json'
            ]
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode == 200) {
            $clientes = json_decode($response, true);
            return $clientes['data'] ?? null;
        }

        return "Error al obtener los clientes. Código: $httpCode Respuesta: $response";
    }

    public function obtenerDetalleCliente($id) {
        $curl = curl_init();
    
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiUrl . "/$id",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->token,
                'Accept: application/json'
            ]
        ]);
    
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
    
        if ($httpCode == 200) {
            $cliente = json_decode($response, true);
            return $cliente['data'] ?? null;
        }
    
        return [
            'error' => true,
            'message' => "Error al obtener los detalles del cliente. Código: $httpCode Respuesta: $response"
        ];
    }

    public function actualizarCliente($id, $name, $email, $password, $phone_number) {
        $curl = curl_init();
    
        $data = [
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'phone_number' => $phone_number
        ];
    
        if (!empty($password)) {
            $data['password'] = $password;
        }
    
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->token,
                'Content-Type: application/x-www-form-urlencoded'
            ]
        ]);
    
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
    
        return $httpCode == 200 ? true : "Error al actualizar el cliente. Respuesta: $response";
    }
    
    

    public function eliminarCliente($id) {
        $apiUrl = $this->apiUrl . "/$id";
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'DELETE',
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->token
            ]
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return $httpCode == 200; 
    }
}

if (isset($_GET['action'])) {
    $clienteController = new ClienteController();

    switch ($_GET['action']) {
        case 'delete':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                if ($clienteController->eliminarCliente($id)) {
                    header("Location: ../tpm/application/client_list.php");
                } else {
                    echo "Error al eliminar el cliente.";
                }
            } else {
                echo "ID del cliente no especificado.";
            }
            break;

        default:
            echo "Acción no válida.";
            break;
    }
}

?>
