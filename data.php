<?php
require_once('auth.php'); // подключение к базе данных

header('Content-Type: application/json');

if ($_GET['action'] === 'loadEmployee') {
    $staffId = intval($_GET['staff_id']);
    
    try {
        $stmt = $pdo->prepare('SELECT * FROM staff WHERE id_staff=:sid');
        $stmt->execute([ ':sid' => $staffId ]);
        $employee = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$employee) {
            echo json_encode(['success'=>false,'message'=>'Сотрудник не найден']);
            exit;
        }
        
        // Получаем торговые автоматы, привязанные к этому сотруднику
        $stmtVM = $pdo->prepare('SELECT machine_model, location_address FROM vending_machines WHERE ID_employee=:eid');
        $stmtVM->execute([ ':eid' => $staffId ]);
        $vendingMachines = $stmtVM->fetchAll(PDO::FETCH_ASSOC);
        
        // Получаем доставки, выполненные сотрудником
        $stmtD = $pdo->prepare('SELECT ID_delivery, delivery_date, delivered FROM delivery WHERE ID_employee=:did');
        $stmtD->execute([ ':did' => $staffId ]);
        $deliveries = $stmtD->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'success'=>true,
            'data'=>[
                'name'=>$employee['name'],
                'id_machines'=>$employee['id_machines'],
                'salary'=>$employee['salary'],
                'telephone'=>$employee['telephone'],
                'vendingMachines'=>$vendingMachines,
                'deliveries'=>$deliveries
            ]
        ]);
    } catch(Exception $ex) {
        echo json_encode(['success'=>false,'message'=>$ex->getMessage()]);
    }
}
?>