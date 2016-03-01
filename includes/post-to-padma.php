<?php

// if form data has key 'padma_ignore_this_form' data wont be forwarded
function padma_post_form($data){
  if(!isset($data['padma_ignore_this_form'])){

    $data = apply_filters('padma_merge_options', $data);


    $response = wp_remote_post( "https://crm.padm.am/api/v1/form_integration", array(
      'method'      => 'POST',
      'httpversion' => '1.0',
      'blocking'    => true,
      'headers'     => array(),
      'body'        => $data,
      'cookies'     => array()
      )
    );

    if ( is_wp_error( $response ) ) {
      return $response->get_error_message();
    } else {
      return true;
    }
  }
};
add_action("padma_post_form","padma_post_form");

function padma_merge_options($data){

  // in array_merge 2nd argument has presendence over first for equal keys

  if(!empty(get_option('padma_communication_username'))){
    $data = array_merge(array('padma_username' => get_option('padma_communication_username')),$data);
  }

  if(!empty(get_option('padma_api_key'))){
    $data = array_merge($data,array('api_key' => get_option('padma_api_key')));
  }

  return $data;
};
add_action("padma_merge_options","padma_merge_options");

?>