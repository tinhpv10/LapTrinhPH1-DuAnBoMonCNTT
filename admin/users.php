<?php

$users = [
    [
        "id" => 1,
        "name" => "Trân",
        "email" => "tran@gmail.com",
        "role" => "Admin"
    ],

    [
        "id" => 2,
        "name" => "Lan",
        "email" => "lan@gmail.com",
        "role" => "User"
    ]
];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý tài khoản</title>
</head>
    <style>

        body{
            font-family: Arial;
            background: #f5f5f5;
        }

        h1{
            text-align: center;
            margin-top: 30px;
        }

        table{
            width: 80%;
            margin: 30px auto;
            border-collapse: collapse;
            background: white;
        }

        th{
            background: black;
            color: white;
            padding: 12px;
        }

        td{
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        button{
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        }

        .sua{
            background: green;
            color: white;
        }

        .xoa{
            background: red;
            color: white;
        }

    </style>

</head>

<body>

    <h1>Quản lý tài khoản</h1>

    <table>

        <tr>
            <th>ID</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>Vai trò</th>
            <th>Hành động</th>
        </tr>

        <?php
            foreach($users as $u){
        ?>

        <tr>

            <td>
                <?php echo $u['id']; ?>
            </td>

            <td>
                <?php echo $u['name']; ?>
            </td>

            <td>
                <?php echo $u['email']; ?>
            </td>

            <td>
                <?php echo $u['role']; ?>
            </td>

            <td>
                <button class="sua">Sửa</button>
                <button class="xoa">Xóa</button>
            </td>

        </tr>

        <?php
            }
        ?>

    </table>

</body>

</html>