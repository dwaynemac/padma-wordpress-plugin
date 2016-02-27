<?php

register_activation_hook( __FILE__, 'padma_padma_thriveleads_integration_activated' );
function padma_padma_thriveleads_integration_activated() {
    // actions for activation
};

register_deactivation_hook( __FILE__, 'padma_padma_thriveleads_integration_deactivated' );
function padma_padma_thriveleads_integration_deactivated(){
    // actions for deactvation
};

?>