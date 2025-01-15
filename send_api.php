<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // URL ของ API
    $URL = "https://invoice.nekoth.com/API.php/create";

    // รับข้อมูลจากฟอร์ม
    $description = trim($_POST['description'] ?? '');
    $payment = trim($_POST['payment'] ?? '');
    $file = $_FILES['fileUpload'] ?? null;

    $newFileName = ''; // กำหนดค่าเริ่มต้นให้ชื่อไฟล์

    // ตรวจสอบว่าไฟล์ถูกส่งมา
    if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
        // ตรวจสอบชนิดไฟล์ที่อนุญาต
        $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions)) {
            echo json_encode([
                'success' => false,
                'message' => 'กรุณาอัปโหลดไฟล์ .pdf, .jpg, .jpeg, หรือ .png เท่านั้น'
            ]);
            exit;
        }

        // สร้างชื่อไฟล์ใหม่ไม่ให้ซ้ำ
        $newFileName = uniqid() . '.' . $fileExtension;

        // กำหนดโฟลเดอร์สำหรับเก็บไฟล์
        $uploadDirectory = '../../file-bill/';

        $fileUploadPath = $uploadDirectory . $newFileName;

        // อัปโหลดไฟล์ไปยังโฟลเดอร์ที่กำหนด
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

    // เตรียมข้อมูล Payload
    $payload = [
        "user_id" => "1", // ตัวอย่าง user_id
        "description" => $description,
        "payment" => $payment,
        "fileUpload" => $newFileName, // ชื่อไฟล์ที่อัปโหลด
    ];

    // การตั้งค่า HTTP Request
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

    // ตรวจสอบการตอบกลับจาก API
    if ($responseData['create success'] ?? true) {
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
