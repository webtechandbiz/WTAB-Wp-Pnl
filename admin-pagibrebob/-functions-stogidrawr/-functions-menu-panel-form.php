<?php
//# Panel form sections
function _getSectionsFields(){
    $ary_ = array(
        'Section A' => 
            array(
                'section_slug' => 'section_a_slug',
                'fields' => array(
                    'First Step Label' => 
                        array(
                            'field_slug' => 'field_aa_slug',
                            'field_type' => 'text' //# It could be: text, textarea, select, checkbox
                        )
                    ,
                    'Second Step Label' => 
                        array(
                            'field_slug' => 'field_ab_slug',
                            'field_type' => 'text'
                        )
                    ,
                )
            ),
        
        'Section B' => 
            array(
                'section_slug' => 'section_b_slug',
                'fields' => array(
                    'First Step Label' => 
                        array(
                            'field_slug' => 'field_ba_slug',
                            'field_type' => 'text'
                        )
                    ,
                    'Second Step Label' => 
                        array(
                            'field_slug' => 'field_bb_slug',
                            'field_type' => 'text'
                        )
                    ,
                    'Third Step Label' => 
                        array(
                            'field_slug' => 'field_bc_slug',
                            'field_type' => 'select',
                            'options' => array(1 => 'uno', 2 => 'due')
                        )
                    ,
                    'Fourth Step Label' => 
                        array(
                            'field_slug' => 'field_bd_slug',
                            'field_type' => 'checkbox'
                        )
                    ,
                )
            )
        
    );
    return $ary_;
}

//# Panel form register
    $ary = _getSectionsFields();
    foreach ($ary as $section_label => $section_conf){
        $section_slug = $section_conf['section_slug'];
        $fields = $section_conf['fields'];

        foreach ($fields as $field_label => $field_conf){
            if($field_label !== '-'){
                register_setting( 'droswavosw_pnl_form_settings_page', $field_conf['field_slug'] );
            }
        }
    }
}

//# Panel form page
function droswavosw_pnl_form_settings_page() {?>
    <div class="wrap">
        <h1>Panel form</h1>
    </div>
    <form class="admin_droswavosw_pnl_form_settings_page_table" method="post" action="options.php">
        <?php settings_fields( 'droswavosw_pnl_form_settings_page' ); ?>
        <?php do_settings_sections( 'droswavosw_pnl_form_settings_page' ); ?>
        <table><?php
            $ary = _getSectionsFields();
            foreach ($ary as $section_label => $section_conf){
                $section_slug = $section_conf['section_slug'];
                $fields = $section_conf['fields'];

                echo '<tr><td colspan="2"><b>'.$section_label.'</b></td></tr>';
                foreach ($fields as $field_label => $field_conf){
                    if($field_label !== '-'){
                        switch ($field_conf['field_type']) {
                            case 'text':
                                echo '
                                    <tr>
                                        <td>'.$field_label.'</td><td><input type="text" name="'.$field_conf['field_slug'].'" value="'.get_option($field_conf['field_slug']).'"/></td>
                                    </tr>';
                                break;

                            case 'textarea':
                                echo '
                                    <tr>
                                        <td>'.$field_label.'</td><td><textarea name="'.$field_conf['field_slug'].'">'.get_option($field_conf['field_slug']).'</textarea></td>
                                    </tr>';
                                break;

                            case 'select':
                                if(isset($field_conf['options']) && is_array($field_conf['options'])){
                                    $_options = '';
                                    $_option_selected = false;
                                    foreach ($field_conf['options'] as $_option_value => $option_label){
                                        if(intval(get_option($field_conf['field_slug'])) === intval($_option_value)){
                                            $_options .= '<option selected="selected" value="'.$_option_value.'">'.$option_label.'</option>';
                                        }else{
                                            $_options .= '<option value="'.$_option_value.'">'.$option_label.'</option>';
                                        }
                                    }
                                    if(!$_option_selected){
                                        $_options = '<option value="">-</option>'.$_options;
                                    }
                                    echo '
                                        <tr>
                                            <td>'.$field_label.'</td><td><select id="'.$field_conf['field_slug'].'" name="'.$field_conf['field_slug'].'">'.$_options.'</select></td>
                                        </tr>';
                                }
                                break;

                            case 'checkbox':
                                $_options = '';
                                $_option_selected = false;

                                if(intval(get_option($field_conf['field_slug'])) == 1){
                                    $_option_selected = true;
                                }
                                echo '<input type="hidden" id="'.$field_conf['field_slug'].'" name="'.$field_conf['field_slug'].'" value="'.get_option($field_conf['field_slug']).'"/></td>';
                                if($_option_selected){
                                    echo '
                                        <tr>
                                            <td>'.$field_label.'</td><td><input class="wtab_chk" checked="checked" type="checkbox" id="chk_'.$field_conf['field_slug'].'" name="chk_'.$field_conf['field_slug'].'" value="1"/></td>
                                        </tr>';
                                }else{
                                    echo '
                                        <tr>
                                            <td>'.$field_label.'</td><td><input class="wtab_chk" type="checkbox" id="chk_'.$field_conf['field_slug'].'" name="chk_'.$field_conf['field_slug'].'" value="0"/></td>
                                        </tr>';
                                }
                                break;

                            default:
                                break;
                        }
                    }
                }
            }
            ?>
        </table>
        <?php submit_button(); ?>
    </form><?php
}

add_action( 'admin_init', 'register_pnl_form_droswavosw_settings' );
