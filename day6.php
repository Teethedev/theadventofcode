<?php
//Set the banks in an array
$banks = array(0, 5, 10, 0, 11, 14, 13, 4, 11, 8, 8, 7, 1, 4, 12, 11);

function cycles_before_seen_before($banks){

    $cycles = 0;
    $bank_configuration_states = array();
    $obtained_hash = "";
    $stop_iteration = 0;

    while($stop_iteration < 1){
        $bank_highest_no_blocks_v = max($banks); //determine value of bank with highest number of blocks 
        $index_of_bank_highest_no_blocks = array_search($bank_highest_no_blocks_v, $banks); //determine index of bank with highest number of blocks 
        $current_banks_configuration = md5(implode($banks)); //Hash state of the current banks state
        array_push($bank_configuration_states, $current_banks_configuration); //Push the hash to array with all past hash states 
        $banks[$index_of_bank_highest_no_blocks] = 0; //set value of bank with highest blocks to zero
        $value_to_distribute = $bank_highest_no_blocks_v; //Value that needs to be distributed

        foreach($banks as $index => $bank){ //Distribute the blocks to the upper part of the banks
            if($index > $index_of_bank_highest_no_blocks){
                if($value_to_distribute > 0){
                   $banks[$index] = $bank + 1;
                   $value_to_distribute--;
                }
            }
        }

        while($value_to_distribute > 0){ //Now distribute the blocks starting with the first bank
          foreach($banks as $index => $bank){
          if($value_to_distribute > 0){
                   $banks[$index] = $bank + 1;
                   $value_to_distribute--;
            }
          }
        }

      $obtained_hash = md5(implode($banks)); //create new hash to capture the current state of the banks' configuration

      if(in_array($obtained_hash, $bank_configuration_states)){ //If the obtained hash is in the list of previously seen hashes, it means the current configuration was seen before
          $stop_iteration = 1;
      }

      array_push($bank_configuration_states , $obtained_hash); //Add the generated state hash to list of all state hashes encountered
      //echo $obtained_hash ."<br>";
      $cycles++; //Increment the cycles
    }

  return $cycles; //This returns number of iterations made before a configuration state that was seen before was encountered again
    
}

echo cycles_before_seen_before($banks) ." redistribution cycles must be completed before a configuration is produced that has been seen before";
//I hope you realized that this solution has the exact number of code lines as my day 8 solution!
