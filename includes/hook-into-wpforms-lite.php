<?php

add_action("wpforms_process_complete", "padma_forward_wpforms_lite_to_padma", 10, 4);

function padma_forward_wpforms_lite_to_padma($fields, $entry, $form_data, $entry_id) {
  if (!is_array($fields) || empty($fields)) {
    return;
  }

  $post_data = padma_wpforms_lite_extract_post_data($fields);
  if (empty($post_data)) {
    return;
  }

  $post_data = apply_filters("padma_filter_form_data", $post_data);
  do_action("padma_post_form", $post_data);
}

function padma_wpforms_lite_extract_post_data($fields) {
  $post_data = array();

  foreach ($fields as $field_id => $field) {
    if (!is_array($field)) {
      continue;
    }

    $key = "";
    if (!empty($field["name"]) && is_string($field["name"])) {
      $key = padma_wpforms_lite_normalize_key($field["name"]);
    }

    if (empty($key)) {
      $field_id_key = padma_wpforms_lite_normalize_key((string) $field_id);
      if (empty($field_id_key)) {
        $field_id_key = "unknown";
      }
      $key = "field_" . $field_id_key;
    }

    $value = null;
    if (isset($field["value_raw"]) && is_array($field["value_raw"]) && !empty($field["value_raw"])) {
      $value_raw = array();
      foreach ($field["value_raw"] as $raw_value) {
        if (is_scalar($raw_value)) {
          $raw_value = trim((string) $raw_value);
          if ($raw_value !== "") {
            $value_raw[] = $raw_value;
          }
        }
      }

      if (!empty($value_raw)) {
        $value = implode(", ", $value_raw);
      }
    } elseif (isset($field["value"]) && is_scalar($field["value"])) {
      $value = trim((string) $field["value"]);
    }

    if ($value === null || $value === "") {
      continue;
    }

    if (array_key_exists($key, $post_data)) {
      $field_id_key = padma_wpforms_lite_normalize_key((string) $field_id);
      if (empty($field_id_key)) {
        $field_id_key = "duplicate";
      }

      $duplicate_key = $key . "_" . $field_id_key;
      $duplicate_index = 2;
      while (array_key_exists($duplicate_key, $post_data)) {
        $duplicate_key = $key . "_" . $field_id_key . "_" . $duplicate_index;
        $duplicate_index++;
      }

      $key = $duplicate_key;
    }

    $post_data[$key] = $value;
  }

  return $post_data;
}

function padma_wpforms_lite_normalize_key($raw_label) {
  $key = strtolower((string) $raw_label);
  $key = preg_replace("/[^a-z0-9]+/", "_", $key);
  $key = preg_replace("/_+/", "_", $key);
  $key = trim($key, "_");

  return $key;
}

?>
