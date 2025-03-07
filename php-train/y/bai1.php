<?php 
// $total1 = 0;
// $total2 = 0;
// $total3 = 0;

// for ($i = 0 ; $i<10; $i++){
//     if ( $i %3 == 0){
//         echo "3: " . $i . "<br>";
//         $total1 = $total1 + $i;
//     }
//     if($i %2 == 0){
//         echo "2: " . $i . "<br>";
//         $total2 = $total2 +$i;
//     }
//     if($i %5 ==0 ){
//         echo "5: " . $i . "<br>";
//         $total3 = $total3 + $i;
//     }
// }

//     echo $total1 . " "; 
//     echo $total2 . " ";
//     echo $total3;

//    0 1 2 3 4 5 6 7 8 9
//    18
//    20
//    5
// $a=1;
// $b=2;
// function sumNumber($x,$y){
//     echo $x + $y;
// }

// sumNumber ($a , $b);
// $i=0;
// $arrays = [2,6,3,7,9,2,5,7,9,6];
// for ($i = 0 ; $i >= $array ; $i++){
//     echo $i;

// foreach ($arrays as $array);
//     if($array > $i ){
//     echo $array;
// }
// }


// $numbers = [1,4,6,84,2,3,58,6,4,6];
// $maxNumber = $numbers[0];
// foreach ($numbers as $number){
//     if($maxNumber < $number){
//        $maxNumber = $number;
//     }
// }
// echo $maxNumber;


// $a = 3;
// $b = 6;

// function order (&$a, &$b){
//     $temp = $a;
//     $a = $b;
//     $b = $temp;
// }

// order($a , $b);

// echo $a . $b;

// tạo giá trị ban đầu 
// $x = [2,6,2,5,8,7,9,3,5,7,3,42,6,8];
// $y = [];
// $z = [];
// vòng lặp foreach 

// foreach ($x as $xx){
    // if ($xx % 2 == 0 or $xx % 3  == 0){
    //     $y[] = $xx;
    // }
    // if ( $xx % 3  == 0){
    //     $z[] = $xx;
    // }
   

// }

// print_r($y) ;
// print_r ($z);
// $x = [2,6,2,5,8,7,9,3,5,7,3,42,6,8];
// $y = [];
// $a = 2;

// foreach ($x as $xx){
//     $aa = $a * $xx ;
//     $y []= $aa;
// }
// print_r ($y);

// Tính tổng hai số:

// $a = 10;
// $b = 20;

// function sum($a , $b){
//     echo $a +$b;
// }

// sum($a, $b);


// Đổi vị trí cho 2 số;
// $a =10;
// $b= 20;
// $tamp = $a;

// $a = $b;
// $b =$tamp;

// echo $a . " ". $b;

//  Tìm Số Lớn Nhất Trong Mảng;
// $mangs = [2,3,6,8,1,3,6,9,4,3,6,4,6,8,5,4,3,6,7,9];

// $maxNumber = $mangs[0];
// foreach ($mangs as $mang){
//     $maxNumber < $mang ;
//     $maxNumber = $mang;
// }
//     echo $maxNumber;

// Từ một mãng, trả về 2 mãng các số chẵn lẻ.
// $mangs = [2,3,6,8,1,3,6,9,4,3,6,4,6,8,5,4,3,6,7,9];

// $c = [];
// $l = [];
//     foreach ($mangs as $mang){
//         if ($mang %2 == 0){ 
//             $c[] = $mang;
//         }
//     }
//     print_r ($c);

// Tính Tổng Các Số Trong Mảng
$mangs = [2,3,6,8,1,3,6,9,4,3,6,4,6,8,5,4,3,6,7,9];
$tong = 0;
foreach ($mangs as $mang){
    $tong += $mang;
}
    echo $tong;
