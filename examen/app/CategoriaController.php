<?php
class CategoriaController
{
    private $apiUrl = "https://crud.jonathansoto.mx/api/categories";
    private $token = '2042|03bDLVAG9dBXNArtAsGxfVLS5Fr14bSOVLU0T1hL';

    public function obtenerCategorias()
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

    public function crearCategoria($data)
    {
        $curl = curl_init();
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
        curl_close($curl);

        return $response ? json_decode($response, true) : false;
    }

    public function eliminarCategoria($id)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "{$this->apiUrl}/{$id}",
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
?>
