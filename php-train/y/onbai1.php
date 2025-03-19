<?php 
// Tính tổng 2 số với Function

$ba = 25;
$bb =30;

function tong($a,$b){
    echo $a + $b;
}   
    echo tong($ba,$bb);

// Đổi vị trí 2 số a và b

$a = 50;
$b = 100;

$goi = $a;

$a = $b;
$b = $goi; 

echo $a . "   " . $b;

// Tìm Số Lớn Nhât Trong Mảng

$mangs = [345,5,64,5,76,8,54,53,42,43345,567,657,5234,34,46,8,56,45,6567,3,53,65,87,6];
$max = $mangs[0];

foreach ($mangs as $mang ){
    if ($max < $mang){
        $max = $mang;
    }
}   echo $max;

// Từ 1 mảng trả về 2  mảng có số chẵn và số lẻ

$mangs = [345,5,64,5,76,8,54,53,42,43345,567,657,5234,34,46,8,56,45,6567,3,53,65,87,6,9];
$chan = [];
$le = [];

foreach ($mangs as $mang){
    if($mang % 2 == 0  or $mang % 3 == 0 && $mang % 6 == 0){
        $chan [] = $mang;
    }
}   print_r ($chan);