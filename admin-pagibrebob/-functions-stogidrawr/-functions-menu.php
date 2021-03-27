<?php
function droswavosw_create_menu() {
    add_menu_page('WTAB Panel', 'Panel', 'administrator', __FILE__, 'droswavosw_settings_page' , plugins_url('/images/icon.png', __FILE__) );

    add_submenu_page(__FILE__, 'Panel form', 'Panel form', 'administrator', 'Panel form', 'droswavosw_pnl_form_settings_page');
}
