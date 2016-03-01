<?php

function padma_filter_form_data($data){

  foreach (array_keys($data) as $key){
    if(preg_match("/.*captcha.*/",$key)==1){
      unset($data[$key]);
    }
    if(preg_match("/.*submit.*/",$key)==1){
      unset($data[$key]);
    }
    if(preg_match("/.*_asset.*/",$key)==1){
      unset($data[$key]);
    }
    if(preg_match("/url/",$key)==1){
      unset($data[$key]);
    }
  }

  return $data;
};
add_filter("padma_filter_form_data", "padma_filter_form_data");

?>