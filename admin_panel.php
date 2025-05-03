<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Панель Администратора</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { text-align: center; color: #333; margin-top: 20px; }
        button { padding: 10px 20px; background-color: #007BFF; color: white; border: none; cursor: pointer; transition: all 0.3s ease-in-out; }
        button:hover { background-color: #0056b3; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
        input[type=number], select { padding: 8px; box-sizing: border-box; margin-right: 10px; }
    </style>
</head>
<body>
<h1>Панель Администраторa</h1>
<div style="display: flex; justify-content: center; gap: 20px;">
    <button onclick="openStaff()">Сотрудники</button>
    <button onclick="window.location.href='orders_deliveries.php'">Заказы-Доставки</button>
    <button onclick="window.location.href='orders.php'">Заказы</button>
    <button onclick="window.location.href='deliveries.php'">Доставки</button>
    <button onclick="window.location.href='vending_machines.php'">Торговые автоматы</button>
    <button onclick="window.location.href='users.php'">Пользователи</button>
</div>

<!-- Модальное окно -->
<div id="modal" class="modal" style="display:none; position:fixed; z-index:1; left:0; top:0; width:100%; height:100%; overflow:auto; background-color:rgba(0,0,0,0.4);">
    <div style="background-color:#fefefe;margin:15% auto;padding:20px;border:1px solid #888;width:80%;min-height:300px;position:relative;">
        <span class="close" onclick="document.getElementById('modal').style.display='none';">&times;</span>
        <h2 id="employeeTitle"></h2>
        <!-- Кнопки навигации сотрудников -->
        <div style="display:flex;justify-content:center;gap:10px;margin-bottom:20px;">
            <button onclick="prevEmployee()">Предыдущий сотрудник</button>
            <button onclick="nextEmployee()">Следующий сотрудник</button>
        </div>
        
        <!-- Основная информация о сотруднике -->
        <p><strong>ID закреплённого автомата:</strong> <span id="idMachines"></span></p>
        <p><strong>Зарплата:</strong> <span id="salary"></span></p>
        <p><strong>Телефон:</strong> <span id="phone"></span></p>
        
        <!-- Таблица торговых автоматов и доставок -->
        <table id="infoTable">
            <tr>
                <th>Модель автомата:</th>
                <th>Адрес места нахождения:</th>
                <th>ID доставки:</th>
                <th>Дата доставки:</th>
                <th>Доставлено:</th>
            </tr>
        </table>
    </div>
</div>

<script>
let currentStaffId = <?php echo isset($currentUser['id_staff']) ? intval($currentUser['id_staff']) : 0 ?>;

function openStaff() {
    document.getElementById('modal').style.display = 'block';
    loadCurrentEmployee(currentStaffId);
}

async function fetchData(endpoint, data) {
    const response = await fetch(`data.php?${new URLSearchParams(data)}`);
    return await response.json();
}

async function loadCurrentEmployee(staffId) {
    try {
        let employeeData = await fetchData('data.php', { action: 'loadEmployee', staff_id: staffId });
        if (employeeData.success) {
            let emp = employeeData.data;
            
            document.getElementById('employeeTitle').innerText = `Сотрудник ${emp.name}`;
            document.getElementById('idMachines').innerText = emp.id_machines;
            document.getElementById('salary').innerText = emp.salary;
            document.getElementById('phone').innerText = emp.telephone;
            
            let infoTableBody = '';
            for(let vm of emp.vendingMachines) {
                infoTableBody += `<tr><td>${vm.machine_model}</td><td>${vm.location_address}</td><td>-</td><td>-</td><td>-</td></tr>`;
            }
            for(let d of emp.deliveries) {
                infoTableBody += `<tr><td>-</td><td>-</td><td>${d.ID_delivery}</td><td>${d.delivery_date}</td><td>${d.delivered}</td></tr>`;
            }
            document.getElementById('infoTable').innerHTML = `<tr><th>Модель автомата:</th><th>Адрес места нахождения:</th><th>ID доставки:</th><th>Дата доставки:</th><th>Доставлено:</th></tr>` + infoTableBody;
        } else {
            alert(employeeData.message);
        }
    } catch(err) {
        console.error(err);
    }
}

function nextEmployee() {
    currentStaffId++;
    loadCurrentEmployee(currentStaffId);
}

function prevEmployee() {
    currentStaffId--;
    loadCurrentEmployee(currentStaffId);
}
</script>

</body>
</html>