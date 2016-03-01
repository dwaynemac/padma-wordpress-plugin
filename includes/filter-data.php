<?php

function padma_filter_form_data($post_data){
  return $post_data;
};
add_filter("padma_filter_form_data", "padma_filter_form_data");

?>