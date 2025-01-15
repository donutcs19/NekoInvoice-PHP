<?php
require_once("connect_db.php");


class API extends Config
{
    private $tableBill = "invoice_bill";
    private $tableUser = "invoice_users";
    private $tableOrganize = "invoice_organize";
    private $tablePosition = "invoice_position";

    public function create($data)
    {
        $sql = "INSERT INTO {$this->tableBill} (user_id, description, payment, file, status, bill_create_at, bill_update_at) 
                VALUES (:user_id, :description, :payment, :fileUpload, 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':user_id' => $data['user_id'],
                ':description' => $data['description'],
                ':payment' => $data['payment'],
                ':fileUpload' => $data['fileUpload'],
                
            ]);
            echo json_encode(['success' => true, 'message' => 'created']);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

  public function deleteBill($data)
    {

         $sql = "SELECT status FROM {$this->tableBill} WHERE bill_id = :bill_id";

try {
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':bill_id', $data['id'], PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC); // Use fetch instead of fetchAll
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}


if ($result && in_array($result['status'], ['4', '3', '2'])) {
    echo json_encode(['error' => true, 'message' => 'ไม่สามารถลบรายการซ้ำอีกครั้งได้']);
} elseif ($result && $result['status'] == '1') {
    $sql = "UPDATE {$this->tableBill} SET status = '4', bill_update_at = CURRENT_TIMESTAMP WHERE bill_id = :id";
    try {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':id' => $data['id']
        ]);
        echo json_encode(['success' => true, 'message' => 'deleted']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}

}

    public function listBillUser($id) {
        
        $sql = "SELECT * FROM {$this->tableBill} WHERE user_id = :user_id AND status != '4'";
    
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':user_id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($results);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
    

    public function listBillAdmin($org)
    {
        $sql = "SELECT * FROM {$this->tableBill} INNER JOIN {$this->tableUser} ON {$this->tableBill}.user_id = {$this->tableUser}.id WHERE 
        organize = :org AND status != '4'" ;
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':org', $org, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode( $results);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }


    public function updateStatus($data)
    {
        $sql = "UPDATE {$this->tableBill} SET status = :status, bill_update_at = CURRENT_TIMESTAMP WHERE bill_id = :id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':id' => $data['id'],
                ':status' => $data['status']
            ]);
            echo json_encode(['success' => true,'message' => 'updated']);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
   

     public function listDelete($org)
    {
        
        $sql = "SELECT bill_id, description, payment, file, bill_create_at, bill_update_at, full_name, position, organize, status FROM {$this->tableBill} INNER JOIN {$this->tableUser}  ON {$this->tableBill}.user_id = {$this->tableUser}.id WHERE organize = :org AND status ='4'";
        try {
           $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':org', $org, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode( $results);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
    

public function listUser($org)
    {
        $sql = "SELECT * FROM {$this->tableUser} WHERE organize = :org";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':org', $org, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode( $results);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
   
    public function updateRole($data)
    {
        $sql = "UPDATE {$this->tableUser} SET urole = :urole, user_update_at = CURRENT_TIMESTAMP WHERE id = :id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':id' => $data['id'],
                ':urole' => $data['urole']
            ]);
            echo json_encode(['success' => true,'message' => 'updated']);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }


    public function disableUser($data)
    {
        $sql = "UPDATE {$this->tableUser} SET urole = 'disable', user_update_at = CURRENT_TIMESTAMP WHERE id = :id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':id' => $data['id']
            ]);
            echo json_encode(['success' => true, 'message' => 'changed']);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
   
public function listOrganize()
    {
        $sql = "SELECT name FROM {$this->tableOrganize}";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($results);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function listPosition()
    {
        $sql = "SELECT name FROM {$this->tablePosition}";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($results);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function listBtnStatus($org)
    {
        $sql = "SELECT status FROM {$this->tableBill} INNER JOIN {$this->tableUser} ON {$this->tableBill}.user_id = {$this->tableUser}.id WHERE organize = :org";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':org', $org, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($results);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

}
