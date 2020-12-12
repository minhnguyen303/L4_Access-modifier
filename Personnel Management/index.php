<?php
include_once "dataIO.php";
include_once "Manager/EmployeeManager.php";
include_once "Employee/Employee.php";

use Manager\EmployeeManager;
use Employee\Employee;

$dataLoad = load();
$manager = new EmployeeManager();
if (count($dataLoad) > 0) {
    foreach ($dataLoad as $value) {
        //var_dump($value);
        $employee = new Employee($value[0], $value[1], $value[2], $value[3], $value[4]);
        $manager->create($employee);
    }
}
$employees = $manager->display();

?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="styles.css">
        <title>Document</title>
    </head>
    <body>
    <form method="post">
        <fieldset>
            <legend>Thêm nhân sự</legend>
            <input type="text" name="lastname" placeholder="Họ" required="required">
            <input type="text" name="firstname" placeholder="Tên" required="required">
            Ngày sinh: <input type="date" name="birth" placeholder="Ngày sinh" required="required">
            <input type="text" name="address" placeholder="Địa chỉ" required="required">
            <input type="text" name="job" placeholder="Vị trí công việc" required="required">
            <button class="submit">Thêm</button>
        </fieldset>
    </form>
    <form method="post">
        <fieldset>
            <legend>Chỉnh sửa và xóa</legend>
            <input type="text" name="id" placeholder="ID" required="required">
            <input type="text" name="lastname" placeholder="Họ">
            <input type="text" name="firstname" placeholder="Tên">
            Ngày sinh: <input type="date" name="birth" placeholder="Ngày sinh">
            <input type="text" name="address" placeholder="Địa chỉ">
            <input type="text" name="job" placeholder="Vị trí công việc">
            <select name="actions">
                <option value="edit">Sửa</option>
                <option value="remove">Xóa</option>
            </select>
            <button class="submit">Cập nhật</button>
        </fieldset>
    </form>
    <table>
        <caption><h2>Danh sách nhân sự</h2></caption>
        <tr>
            <th>ID</th>
            <th>Họ</th>
            <th>Tên</th>
            <th>Ngày sinh</th>
            <th>Địa chỉ</th>
            <th>Vị trí công việc</th>
        </tr>
        <?php foreach ($employees as $key => $employee): ?>
            <tr>
                <td><?php echo $key ?></td>
                <td><?php echo $employee->getLastName() ?></td>
                <td><?php echo $employee->getFirstName() ?></td>
                <td><?php echo $employee->getBirth() ?></td>
                <td><?php echo $employee->getAddress() ?></td>
                <td><?php echo $employee->getJob() ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    </body>
    </html>
<?php

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $action = $_POST['actions'];
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $birth = $_POST['birth'];
    $address = $_POST['address'];
    $job = $_POST['job'];
    if ($action == "edit" || $action == "remove") {
        $id = $_POST['id'];
        if ($action == "edit") {
            $newEmployee = new Employee($lastname, $firstname, $birth, $address, $job);
            $manager->update($id, $newEmployee);
        } else {
            $manager->remove($id);
        }
    } else {
        $user = new Employee($lastname, $firstname, $birth, $address, $job);
        $manager->create($user);
    }

    $array = [];
    foreach ($manager->display() as $value) {
        array_push($array, toArray($value));
    }
    saveData($array);
    header("location:index.php");
}