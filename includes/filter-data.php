<?php

function padma_filter_form_data($data){
  $patterns = array(
    "/captcha/i",
    "/submit/i",
    "/_asset/i",
    "/^url$/i",
    "/_wpnonce/i"
  );

  foreach (array_keys($data) as $key){
    foreach ($patterns as $pattern) {
      if (preg_match($pattern, (string) $key) === 1) {
        unset($data[$key]);
        break;
      }
    }
  }

  return $data;
};
add_filter("padma_filter_form_data", "padma_filter_form_data");

?>
