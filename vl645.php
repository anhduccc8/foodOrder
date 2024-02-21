<?php
$array = array('0','1','6','2','3','8','5','4','7','9');
$array_2 = array();
for($i=1;$i<=6;$i++){
    $arr = array();
    $arr = array_rand($array,2);
    $t =  $arr[0].$arr[1];
    if(!in_array($t, $array_2) && (int)$t < 46){
        array_push($array_2, $t);
    }else{
        $i--;
    }
}
$string = implode('--',$array_2);
echo $string;
