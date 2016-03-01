<?php

// when ThriveLeads form is submitted we'll run our function
add_action("tcb_api_form_submit", "padma_forward_post_to_padma", 10, 1);

function padma_forward_post_to_padma($post_data) {
  $post_data = apply_filters("padma_filter_form_data", $post_data);
  do_action('padma_post_form', $post_data);
}


function padma_filter_tve_data($data){
  return $data;
}
add_filter('padma_filter_form_data', 'padma_filter_tve_data');

?>