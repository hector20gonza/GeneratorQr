<?php
// Datos de la API
$apiUrl = 'http://149.202.12.81/rapidprest_i2/public/api/';
$apiKey = 'sWCkATuQlzT2solMGTM8BumHnr5CcKtrl70r3kVAK6wuVHPq2nAq1O2M0D4w';
$codMaq = 'prueba1'; // Código de la máquina

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos enviados desde el formulario
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];
    $telefono = $_POST['telefono'];

    if (empty($nombre) || empty($cantidad) || empty($telefono)) {
        die('Error: Todos los campos son obligatorios.');
    }

    if (!is_numeric($cantidad) || $cantidad <= 0) {
        die('Error: La cantidad debe ser un número positivo.');
    }

    
    // Datos para generar el código QR
    $data = array(
        'cantidad' => $cantidad,
        'numeroautorizacion' => '5629' // Reemplaza con el valor adecuado si es diferente para cada solicitud
    );

    // Función para realizar la solicitud a la API
    function callAPI($url, $method, $data = false) {
        $curl = curl_init($url);

        // Configurar las opciones de la solicitud
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $GLOBALS['apiKey'],
                'cod_maq: ' . $GLOBALS['codMaq']
            ),
        );

        // Configurar los datos a enviar en caso de que sea una solicitud POST o PUT
        if ($method === 'POST' || $method === 'PUT') {
            $options[CURLOPT_POSTFIELDS] = json_encode($data);
            $options[CURLOPT_HTTPHEADER][] = 'Content-Type: application/json';
        }

        curl_setopt_array($curl, $options);

        // Realizar la solicitud a la API
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        // Decodificar la respuesta JSON
        $responseData = json_decode($response, true);

        // Verificar el código de respuesta HTTP y el estado de la API
        if ($httpCode === 200 && $responseData['state'] === 200) {
          
            return $responseData['data'];
        } else {
            $errorMessage = isset($responseData['message']) ? $responseData['message'] : 'Error en la llamada a la API';
            die('Error: ' . $errorMessage);
        }
    }

    // Generar código QR
    $generateQrUrl = $apiUrl . 'maq1/generarqr/' . $codMaq;
    $response = callAPI($generateQrUrl, 'POST', $data);
    $codigoQR = $response['codigo'];

    

if (isset($codigoQR)) {
    echo '<div class="qr-container" >';
    echo '<img src="https://api.qrserver.com/v1/create-qr-code/?data=' . $codigoQR . '" alt="Código QR" >';
    echo '</div>';
}

   
}
?>