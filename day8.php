<?php

require_once("day8input.php");

//All the logical comparisons are done here
function evaluate_truth_value ($var1, $var2, $op) {
    switch ($op) {
        case "==":  return $var1 == $var2;
        case "!=": return $var1 != $var2;
        case ">=": return $var1 >= $var2;
        case "<=": return $var1 <= $var2;
        case ">":  return $var1 >  $var2;
        case "<":  return $var1 <  $var2;
    default:       return true;
    }   
}

$exploded_input = explode("\n", $string_input); //convert the strin input into one dimensional array
 
$all_registers = array(); //storage for all the registers
foreach($exploded_input as $key => $value){
   $exploded_input[$key] = explode(" ", $value); //splits the input into two dimensional array
}

//get all the registers (in the two dimensional array)
foreach($exploded_input as $key => $value){
  if(!in_array($value[0], $all_registers)){
      array_push($all_registers, $value[0]);
  }
  if(!in_array($value[4], $all_registers)){
    array_push($all_registers, $value[4]);
  }
}

//set the registers to 0 
$initialized_registers = array();
foreach($all_registers as $value){
    $initialized_registers[$value] = 0;
}

//The distribution is performed here
foreach($exploded_input as $value){
        if(evaluate_truth_value($initialized_registers[$value[4]], $value[6], $value[5])){
            if($value[1] == "dec"){
              $initialized_registers[$value[0]] = $initialized_registers[$value[0]] - $value[2];
            }
            if($value[1] == "inc"){
              $initialized_registers[$value[0]] = $initialized_registers[$value[0]] + $value[2];
            }
        }
}

echo max($initialized_registers);
//I hope you realized that this solution has the exact number of code lines as my day 6 solution!
