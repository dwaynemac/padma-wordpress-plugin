<?php

if((WPCF7_VERSION !== null) && (floatval(WPCF7_VERSION)>=4.1)){
  padma_log("detected contactform >= 4.1");

  // wpcf7_submit available since ContacForm7 4.1.2, tested with 4.4
  // add_action("wpcf7_submit", "padma_forward_cf7_to_padma", 10, 1); // SPAM has not been filtered here, maybe cuold filter with $result data ?
  add_action("wpcf7_mail_sent", "padma_forward_cf7_to_padma", 10, 1); // SPAM already filtered here

  // wpcf7_submit provides $form and $result params
  // wpcf7_mail_sent only provide $form
  function padma_forward_cf7_to_padma($form) {
    $submission = WPCF7_Submission::get_instance();
    if ( $submission ) {
      $posted_data = $submission->get_posted_data();
      $posted_data = apply_filters('padma_filter_form_data', $posted_data);
      do_action('padma_post_form', $posted_data);
    }
  };
} else if((WPCF7_VERSION !== null) && (floatval(WPCF7_VERSION)<=4.1)){
  padma_log("detected contactform < 4.1");
  add_action("wpcf7_mail_sent", "padma_forward_old_cf7_to_padma", 10, 1);

  function padma_forward_old_cf7_to_padma($form) {
    $posted_data = $form->posted_data;
    $posted_data = apply_filters('padma_filter_form_data', $posted_data);
    do_action('padma_post_form', $posted_data);
  };
}

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
