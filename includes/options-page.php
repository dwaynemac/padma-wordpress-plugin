<?php

add_action( 'admin_menu', 'padma_custom_menu');
function padma_custom_menu(){
  add_options_page(
    'PADMA Options',
    'PADMA Options',
    'manage_options',
    'padma_options_page',
    'padma_options_page_callback'
  );
};

function padma_options_page_callback(){
      ?>
    <div class="wrap">
        <h2>PADMA Options</h2>
        <form method="post" action="options.php">
          <?php settings_fields('pluginPage'); ?>
          <?php do_settings_sections( 'pluginPage' ); ?>
          <?php submit_button(); ?>
        </form>
    </div>
    <?php
};

add_action( 'admin_init', 'padma_settings_init' );
function padma_settings_init(){
  add_settings_section(
    'padma_settings_section',
    'PADMA-ThriveLeads Integration Configuration',
    'padma_settings_section_title_render',
    'pluginPage'
  );

  add_settings_field(
    'padma_api_key',
    'PADMA API KEY',
    'padma_api_key_setting_render',
    'pluginPage',
    'padma_settings_section'
  );

  add_settings_field(
    'padma_communication_username',
    'Default username for communication',
    'padma_communication_username_render',
    'pluginPage',
    'padma_settings_section'
  );

  add_settings_field(
    'padma_site_name',
    'Nome do site',
    'padma_site_name_render',
    'pluginPage',
    'padma_settings_section'
    );

  register_setting('pluginPage','padma_api_key','padma_no_sanitazion_callback');
  register_setting('pluginPage','padma_communication_username','padma_no_sanitazion_callback');
  register_setting('pluginPage','padma_site_name','padma_no_sanitazion_callback');
};

function padma_settings_section_title_render(){
  echo "";
};

function padma_api_key_setting_render(){
  $apikey = get_option( 'padma_api_key');
  echo "<input name='padma_api_key' id='padma_api_key' type='text' value='$apikey'/>";
};

function padma_site_name_render(){
  $site_name = get_option( 'padma_site_name');
  echo "<input name='padma_site_name' id='padma_site_name' type='text' value='$site_name'/>";
}

function padma_communication_username_render(){
  $username = get_option( 'padma_communication_username');
  echo "<input name='padma_communication_username' id='padma_communication_username' type='text' value='$username'/>";
};

function padma_no_sanitazion_callback($value){
  return $value;
};

?>