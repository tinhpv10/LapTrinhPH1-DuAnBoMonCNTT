<?php

// $age = 8;
// switch($age){
//     case 7:
//     case 8:
//     case 9:
//     case 10: 
//     case 11:
//         echo "Học cấp 1";
//         break;
//     case 12:
//         echo "Học cấp 2";
//         break;
//     case 16:
//         echo "học Cấp 3";
//         break;
//     default:
//         echo "Không thuộc trường hợp nào ở trên";
// }


// $age = false;
// while($age){
//     echo "Không chạy vào đây nhé?";
// }

// do{
//     echo "Có chạy vào đây !!!!";
// }while($age);


// $array = [
//     "Táo",
//     "Cam",
//     "Ổi",
//     "Xoài",
//     "Sầu Riêng"
// ];

// echo $array[2];
// echo $array[4];

$gio_hang = [
    [
        "Táo",
        "Cam",
        "Ổi"
    ],
    [
        "Xoài",
        "Sầu Riêng"
    ]
];
var_dump($gio_hang);
echo "<hr>";
echo $gio_hang[1][1]; //Sầu Riêng
echo "<hr>";




$classes = [
    [
        "name" => "Luận",
        "age" => 18,
        "address" => "Cần Thơ"
    ],
    [
        "name" => "Quí",
        "age" => 20,
        "address" => "Kiên Giang"
    ],
    [
        "name" => "Vy",
        "age" => 18,
        "address" => "Vĩnh Long"
    ]
];
var_dump($classes);
echo "<hr>";

echo $classes[1]["address"]; //Kiên Giang
echo "<hr>";
