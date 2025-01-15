<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $URL = "https://invoice.nekoth.com/API.php/create";

   
    $user_id = $_POST['user_id'] ?? null;
    $description = trim($_POST['description'] ?? '');
    $payment = trim($_POST['payment'] ?? '');
    $file = $_FILES['fileUpload'] ?? null;

    $newFileName = ''; 

    
    if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
        
        $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions)) {
            echo json_encode([
                'success' => false,
                'message' => 'กรุณาอัปโหลดไฟล์ .pdf, .jpg, .jpeg, หรือ .png เท่านั้น'
            ]);
            exit;
        }

        
        $newFileName = uniqid() . '.' . $fileExtension;

        
        $uploadDirectory = '../../file-bill/';

        $fileUploadPath = $uploadDirectory . $newFileName;

        
        if (!move_uploaded_file($file['tmp_name'], $fileUploadPath)) {
            echo json_encode([
                'success' => false,
                'message' => 'ไม่สามารถอัปโหลดไฟล์ได้'
            ]);
            exit;
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'ไม่พบไฟล์ที่อัปโหลด'
        ]);
        exit;
    }

    
    $payload = [
        "user_id" => $user_id, 
        "description" => $description,
        "payment" => $payment,
        "fileUpload" => $newFileName, 
    ];

    
    $options = [
        "http" => [
            "header" => "Content-Type: application/json\r\n",
            "method" => "POST",
            "content" => json_encode($payload),
        ],
    ];

    $context = stream_context_create($options);
    $response = @file_get_contents($URL, false, $context);

    if ($response === false) {
        echo json_encode([
            'success' => false,
            'message' => 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้'
        ]);
        exit;
    }

    $responseData = json_decode($response, true);

    
    if ($responseData['created'] ?? true) {
        echo json_encode([
            'success' => true,
            'message' => 'ข้อมูลถูกบันทึกเรียบร้อยแล้ว'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => $responseData['message'] ?? 'ไม่สามารถบันทึกข้อมูลได้'
        ]);
    }
}
?>
