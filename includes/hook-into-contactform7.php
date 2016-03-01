<?php

// wpcf7_submit available since ContacForm7 4.1.2, tested with 4.4
add_action("wpcf7_submit", "padma_forward_cf7_to_padma", 10, 2);

function padma_forward_cf7_to_padma($form,$result) {
  // TODO has spam been filtered already?
  // TODO has form been validated already?

  $submission = WPCF7_Submission::get_instance();
  if ( $submission ) {
    $posted_data = $submission->get_posted_data();
    $posted_data = apply_filters('padma_filter_form_data', $posted_data);
    do_action('padma_post_form', $posted_data);
  }
};

// removes all _wpcf7* fields from form.
function padma_filter_cf7_data($data){

  foreach (array_keys($data) as $key){
    if(preg_match("/_wpcf7.*/",$key)==1){
      unset($data[$key]);
    }
  }

  return $data;
};
add_filter('padma_filter_form_data','padma_filter_cf7_data');

?>