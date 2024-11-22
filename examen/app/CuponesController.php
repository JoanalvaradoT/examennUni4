<?php
class CuponesController
{
    private $apiUrl = "https://crud.jonathansoto.mx/api/coupons";
    private $token = '1829|jKurAXkQV3gWFxidGeGQEFeojcUskvIeUnp0E2Ro';

    public function createCupon($data)
    {
        $curl = curl_init();

        $data = array_merge($data, [
            'min_product_required' => $data['min_product_required'] ?? '1',
            'count_uses' => $data['count_uses'] ?? '0',
            'valid_only_first_purchase' => $data['valid_only_first_purchase'] ?? '1',
        ]);

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$this->token}",
                "Accept: application/json",
                "Content-Type: application/x-www-form-urlencoded",
            ],
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            echo 'Error en la solicitud: ' . curl_error($curl);
            curl_close($curl);
            return ['error' => 'Error en la solicitud'];
        }

        curl_close($curl);

        $responseData = json_decode($response, true);

        if (!$responseData) {
            echo "Error al decodificar respuesta JSON. Respuesta cruda: $response";
            return ['error' => 'Error al decodificar respuesta JSON'];
        }

        return $responseData;
    }

    public function obtenerCupones()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$this->token}",
                "Accept: application/json",
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response ? json_decode($response, true) : false;
    }

    public function obtenerDetalleCupon($id)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiUrl . '/' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$this->token}",
                "Accept: application/json",
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response ? json_decode($response, true) : false;
    }

    public function editarCupon($id, $data)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiUrl . '/' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$this->token}",
                "Content-Type: application/x-www-form-urlencoded",
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response ? json_decode($response, true) : false;
    }

    public function eliminarCupon($id)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiUrl . '/' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$this->token}",
                "Accept: application/json",
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response ? json_decode($response, true) : false;
    }
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $controller = new CuponesController();

    switch ($action) {
        case 'create':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    'name' => $_POST['name'],
                    'code' => $_POST['code'],
                    'percentage_discount' => $_POST['percentage_discount'],
                    'min_amount_required' => $_POST['min_amount_required'],
                    'start_date' => $_POST['start_date'],
                    'end_date' => $_POST['end_date'],
                    'max_uses' => $_POST['max_uses'],
                    'status' => $_POST['status'],
                    'min_product_required' => $_POST['min_product_required'] ?? '1',
                    'count_uses' => $_POST['count_uses'] ?? '0',
                    'valid_only_first_purchase' => $_POST['valid_only_first_purchase'] ?? '1',
                ];

                $result = $controller->createCupon($data);

                if (isset($result['message']) && $result['message'] === 'Registro creado correctamente') {
                    header("Location: ../tpm/application/consulta_cupones.php?message=Cupón creado correctamente");
                    exit();
                } else {
                    echo "<h2>Error: " . print_r($result, true) . "</h2>";
                }
            }
            break;

        case 'details':
            if (isset($_GET['id'])) {
                header("Location: /unidad4/examen/tpm/application/detalle_cupones.php?id=" . $_GET['id']);
            }
            break;

        case 'delete':
            if (isset($_GET['id'])) {
                $result = $controller->eliminarCupon($_GET['id']);
                if (isset($result['success']) && $result['success'] === true) {
                    header("Location: ../tpm/application/consulta_cupones.php?message=Cupón eliminado correctamente");
                } else {
                    echo "<h2>Error al eliminar el cupón.</h2>";
                }
            }
            break;

        case 'update':
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
                $data = [
                    'name' => $_POST['name'],
                    'code' => $_POST['code'],
                    'percentage_discount' => $_POST['percentage_discount'],
                    'min_amount_required' => $_POST['min_amount_required'],
                    'start_date' => $_POST['start_date'],
                    'end_date' => $_POST['end_date'],
                    'max_uses' => $_POST['max_uses'],
                    'status' => $_POST['status'],
                ];

                $result = $controller->editarCupon($_POST['id'], $data);
                if (isset($result['success']) && $result['success'] === true) {
                    header("Location: ../tpm/application/consulta_cupones.php?message=Cupón actualizado correctamente");
                } else {
                    echo "<h2>Error al actualizar el cupón.</h2>";
                }
            }
            break;

        default:
            echo "<h2>Acción no válida.</h2>";
            break;
    }
}
?>
