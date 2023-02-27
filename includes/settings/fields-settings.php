<?php

function max_fields_settings(){

    add_settings_field(
        'max_sb_location_geo_neighborhood_location',
        __( 'Location (City)', 'max_sb_location_geo' ),
        'max_sb_location_geo_neighborhood_location_details',
        'max_sb_location_geo_settings',
        'max_sb_location_geo_settings_neighborhood',
        array(
            'label_for'         => 'max_sb_location_geo_neighborhood_location',
            'class'             => 'max_sb_location_geo_row',
            'max_sb_location_geo_custom_data' => 'custom',
        )
    );

    add_settings_field(
        'max_sb_location_geo_neighborhood_limit',
        __( 'Limit', 'max_sb_location_geo' ),
        'max_sb_location_geo_neighborhood_limit_details',
        'max_sb_location_geo_settings',
        'max_sb_location_geo_settings_neighborhood',
        array(
            'label_for'         => 'max_sb_location_geo_neighborhood_limit',
            'class'             => 'max_sb_location_geo_row',
            'max_sb_location_geo_custom_data' => 'custom',
        )
    );

    add_settings_field(
        'max_sb_location_geo_neighborhood_sort',
        __( 'Sort By', 'max_sb_location_geo' ),
        'max_sb_location_geo_neighborhood_sort_details',
        'max_sb_location_geo_settings',
        'max_sb_location_geo_settings_neighborhood',
        array(
            'label_for'         => 'max_sb_location_geo_neighborhood_sort',
            'class'             => 'max_sb_location_geo_row',
            'max_sb_location_geo_custom_data' => 'custom',
        )
    );

    add_settings_field(
        'max_sb_location_geo_activities_location',
        __( 'Location (City)', 'max_sb_location_geo' ),
        'max_sb_location_geo_activities_location_details',
        'max_sb_location_geo_settings',
        'max_sb_location_geo_settings_activities',
        array(
            'label_for'         => 'max_sb_location_geo_activities_location',
            'class'             => 'max_sb_location_geo_row',
            'max_sb_location_geo_custom_data' => 'custom',
        )
    );

    add_settings_field(
        'max_sb_location_geo_activities_limit',
        __( 'Limit', 'max_sb_location_geo' ),
        'max_sb_location_geo_activities_limit_details',
        'max_sb_location_geo_settings',
        'max_sb_location_geo_settings_activities',
        array(
            'label_for'         => 'max_sb_location_geo_activities_limit',
            'class'             => 'max_sb_location_geo_row',
            'max_sb_location_geo_custom_data' => 'custom',
        )
    );

    add_settings_field(
        'max_sb_location_geo_activities_sort',
        __( 'Sort By', 'max_sb_location_geo' ),
        'max_sb_location_geo_activities_sort_details',
        'max_sb_location_geo_settings',
        'max_sb_location_geo_settings_activities',
        array(
            'label_for'         => 'max_sb_location_geo_activities_sort',
            'class'             => 'max_sb_location_geo_row',
            'max_sb_location_geo_custom_data' => 'custom',
        )
    );

    add_settings_field(
        'max_sb_location_geo_activities_types',
        __( 'Places Types', 'max_sb_location_geo' ),
        'max_sb_location_geo_activities_types_details',
        'max_sb_location_geo_settings',
        'max_sb_location_geo_settings_activities',
        array(
            'label_for'         => 'max_sb_location_geo_activities_types',
            'class'             => 'max_sb_location_geo_row',
            'max_sb_location_geo_custom_data' => 'custom',
        )
    );

    add_settings_field(
        'max_sb_location_geo_activities_radius',
        __( 'Radius', 'max_sb_location_geo' ),
        'max_sb_location_geo_activities_radius_details',
        'max_sb_location_geo_settings',
        'max_sb_location_geo_settings_activities',
        array(
            'label_for'         => 'max_sb_location_geo_activities_radius',
            'class'             => 'max_sb_location_geo_row',
            'max_sb_location_geo_custom_data' => 'custom',
        )
    );

    add_settings_field(
        'max_sb_location_geo_locations_sentence',
        __( 'Sentence Limit', 'max_sb_location_geo' ),
        'max_sb_location_geo_locations_sentence_details',
        'max_sb_location_geo_settings',
        'max_sb_location_geo_settings_location',
        array(
            'label_for'         => 'max_sb_location_geo_locations_sentence',
            'class'             => 'max_sb_location_geo_row',
            'max_sb_location_geo_custom_data' => 'custom',
        )
    );

    add_settings_field(
        'max_sb_location_geo_gmap_location',
        __( 'Location (City)', 'max_sb_location_geo' ),
        'max_sb_location_geo_gmap_location_details',
        'max_sb_location_geo_settings',
        'max_sb_location_geo_settings_map',
        array(
            'label_for'         => 'max_sb_location_geo_gmap_location',
            'class'             => 'max_sb_location_geo_row',
            'max_sb_location_geo_custom_data' => 'custom',
        )
    );

    add_settings_field(
        'max_sb_location_geo_gmap_radius',
        __( 'Zoom Level', 'max_sb_location_geo' ),
        'max_sb_location_geo_gmap_radius_details',
        'max_sb_location_geo_settings',
        'max_sb_location_geo_settings_map',
        array(
            'label_for'         => 'max_sb_location_geo_gmap_radius',
            'class'             => 'max_sb_location_geo_row',
            'max_sb_location_geo_custom_data' => 'custom',
        )
    );

    add_settings_field(
        'max_sb_location_geo_gmap_height',
        __( 'Map Height', 'max_sb_location_geo' ),
        'max_sb_location_geo_gmap_height_details',
        'max_sb_location_geo_settings',
        'max_sb_location_geo_settings_map',
        array(
            'label_for'         => 'max_sb_location_geo_gmap_height',
            'class'             => 'max_sb_location_geo_row',
            'max_sb_location_geo_custom_data' => 'custom',
        )
    );

    add_settings_field(
        'max_sb_location_geo_gmap_api',
        __( 'API Key', 'max_sb_location_geo' ),
        'max_sb_location_geo_gmap_api_details',
        'max_sb_location_geo_settings',
        'max_sb_location_geo_settings_api',
        array(
            'label_for'         => 'max_sb_location_geo_gmap_api',
            'class'             => 'max_sb_location_geo_row',
            'max_sb_location_geo_custom_data' => 'custom',
        )
    );

    add_settings_field(
        'max_sb_location_geo_weather_api_key',
        __( 'API Key', 'max_sb_location_geo' ),
        'max_sb_location_geo_weather_api_details',
        'max_sb_location_geo_settings',
        'max_sb_location_geo_settings_weather_api',
        array(
            'label_for'         => 'max_sb_location_geo_weather_api_key',
            'class'             => 'max_sb_location_geo_row',
            'max_sb_location_geo_custom_data' => 'custom',
        )
    );

    add_settings_field(
        'max_sb_location_geo_license_key',
        __( 'License Key', 'max_sb_location_geo' ),
        'max_sb_location_geo_license_details',
        'max_sb_location_geo_settings',
        'max_sb_location_geo_settings_license_key',
        array(
            'label_for'         => 'max_sb_location_geo_license_key',
            'class'             => 'max_sb_location_geo_row',
            'max_sb_location_geo_custom_data' => 'custom',
        )
    );
}


function max_sb_location_geo_neighborhood_location_details( $args ){
    $options = get_option( 'max_sb_location_geo_settings' );
    ?>

    <input type="text" id="<?php echo esc_attr( $args['label_for'] ); ?>"
           name="max_sb_location_geo_settings[<?php echo esc_attr( $args['label_for'] ); ?>]"
           value="<?php echo $options[$args['label_for']]; ?>" />
    <?php
}

function max_sb_location_geo_neighborhood_limit_details( $args ){
    $options = get_option( 'max_sb_location_geo_settings' );
    ?>

    <input type="number" id="<?php echo esc_attr( $args['label_for'] ); ?>"
           name="max_sb_location_geo_settings[<?php echo esc_attr( $args['label_for'] ); ?>]"
           value="<?php echo $options[$args['label_for']]; ?>" />
    <?php
}

function max_sb_location_geo_neighborhood_sort_details( $args ){
    $options = get_option( 'max_sb_location_geo_settings' );

    ?>
    <select id="<?php echo esc_attr( $args['label_for'] ); ?>"
            name="max_sb_location_geo_settings[<?php echo esc_attr( $args['label_for'] ); ?>]"
            value="<?php echo $options[$args['label_for']]; ?>">
        <option value="asc" <?php selected( $options['max_sb_location_geo_neighborhood_sort'], 'asc' ); ?>>Ascending</option>
        <option value="desc" <?php selected( $options['max_sb_location_geo_neighborhood_sort'], 'desc' ); ?>>Descending</option>
        <option value="rand" <?php selected( $options['max_sb_location_geo_neighborhood_sort'], 'rand' ); ?>>Randomize</option>
    </select>
    <?php
}

function max_sb_location_geo_activities_location_details( $args ){
    $options = get_option( 'max_sb_location_geo_settings' );

    ?>
    <input type="text" id="<?php echo esc_attr( $args['label_for'] ); ?>"
           name="max_sb_location_geo_settings[<?php echo esc_attr( $args['label_for'] ); ?>]"
           value="<?php echo $options[$args['label_for']]; ?>" />
    <?php

}

function max_sb_location_geo_activities_limit_details( $args ){
    $options = get_option( 'max_sb_location_geo_settings' );
    ?>
    <input type="number" id="<?php echo esc_attr( $args['label_for'] ); ?>"
           name="max_sb_location_geo_settings[<?php echo esc_attr( $args['label_for'] ); ?>]"
           value="<?php echo $options[$args['label_for']]; ?>" />
    <?php
}

function max_sb_location_geo_activities_sort_details( $args ){
    $options = get_option( 'max_sb_location_geo_settings' );

    ?>
    <select id="<?php echo esc_attr( $args['label_for'] ); ?>"
            name="max_sb_location_geo_settings[<?php echo esc_attr( $args['label_for'] ); ?>]"
            value="<?php echo $options[$args['label_for']]; ?>">
        <option value="asc" <?php selected( $options['max_sb_location_geo_activities_sort'], 'asc' ); ?>>Ascending</option>
        <option value="desc" <?php selected( $options['max_sb_location_geo_activities_sort'], 'desc' ); ?>>Descending</option>
        <option value="rand" <?php selected( $options['max_sb_location_geo_activities_sort'], 'rand' ); ?>>Randomize</option>
    </select>
    <?php
}

function max_sb_location_geo_activities_types_details( $args ){
    $options = get_option( 'max_sb_location_geo_settings' );

    ?>
    <input type="text" id="<?php echo esc_attr( $args['label_for'] ); ?>"
           name="max_sb_location_geo_settings[<?php echo esc_attr( $args['label_for'] ); ?>]"
           value="<?php echo ($options[$args['label_for']] != '') ? $options[$args['label_for']] : 'park,restaurant,stadium,tourist_attraction,point_of_interest,landmark'; ?>" />
    <p>Separate types with commas without spaces. For more available places types, you can refer to this <a
                href="https://developers.google.com/maps/documentation/javascript/local-context/supported-types"
                target="_blank">link</a>. </p>
    <?php
}
function max_sb_location_geo_activities_radius_details( $args ){
    $options = get_option( 'max_sb_location_geo_settings' );
    ?>

    <input type="text" id="<?php echo esc_attr( $args['label_for'] ); ?>"
           name="max_sb_location_geo_settings[<?php echo esc_attr( $args['label_for'] ); ?>]"
           value="<?php echo $options[$args['label_for']]; ?>" />
    <p>Set the radius of area to cover. Max is 50000.</p>
    <?php
}

function max_sb_location_geo_locations_sentence_details( $args ){
    $options = get_option( 'max_sb_location_geo_settings' );
    ?>
    <input type="number" id="<?php echo esc_attr( $args['label_for'] ); ?>"
           name="max_sb_location_geo_settings[<?php echo esc_attr( $args['label_for'] ); ?>]"
           value="<?php echo $options[$args['label_for']]; ?>" />
    <?php
}

function max_sb_location_geo_gmap_radius_details( $args ){
    $options = get_option( 'max_sb_location_geo_settings' );
    ?>
    <input type="number" id="<?php echo esc_attr( $args['label_for'] ); ?>"
           name="max_sb_location_geo_settings[<?php echo esc_attr( $args['label_for'] ); ?>]"
           value="<?php echo $options[$args['label_for']]; ?>" />
    <p>Zoom Level Options: 1 - 19.</p>
    <?php
}

function max_sb_location_geo_gmap_height_details( $args ){
    $options = get_option( 'max_sb_location_geo_settings' );
    ?>
    <input type="number" id="<?php echo esc_attr( $args['label_for'] ); ?>"
           name="max_sb_location_geo_settings[<?php echo esc_attr( $args['label_for'] ); ?>]"
           value="<?php echo $options[$args['label_for']]; ?>" />
    <p>Define the height of google map on desktop.</p>
    <?php
}

function max_sb_location_geo_gmap_location_details( $args ){
    $options = get_option( 'max_sb_location_geo_settings' );
    ?>
    <input type="text" id="<?php echo esc_attr( $args['label_for'] ); ?>"
           name="max_sb_location_geo_settings[<?php echo esc_attr( $args['label_for'] ); ?>]"
           value="<?php echo $options[$args['label_for']]; ?>" />
    <?php
}

function max_sb_location_geo_gmap_api_details( $args ){
    $options = get_option( 'max_sb_location_geo_settings' );

    ?>
    <input type="text" id="<?php echo esc_attr( $args['label_for'] ); ?>"
           name="max_sb_location_geo_settings[<?php echo esc_attr( $args['label_for'] ); ?>]"
           value="<?php echo $options[$args['label_for']]; ?>" />
    <p>
        <small>
            This API key can be obtained from
            the <a href="https://console.developers.google.com" target="_BLANK">Google Developers Console</a>
        </small>
    </p>
    <?php
}
function max_sb_location_geo_weather_api_details( $args ){
    $options = get_option( 'max_sb_location_geo_settings' );

    ?>
    <input type="text" id="<?php echo esc_attr( $args['label_for'] ); ?>"
           name="max_sb_location_geo_settings[<?php echo esc_attr( $args['label_for'] ); ?>]"
           value="<?php echo $options[$args['label_for']]; ?>" />
    <p>
        <small>
            This API key can be obtained from the <a href="https://openweathermap.org/api" target="_BLANK">Open Weather</a>
        </small>
    </p>
    <?php
}
function max_sb_location_geo_license_details( $args ){
    $options = get_option( 'max_sb_location_geo_settings' );
    $result  = json_decode(get_option( 'licenses_res' ), true);
    $res     = get_option('max_sb_location_geo_license_key');
    $opt_val = '';
    if (isset($res) && !empty($res)){
        $opt_val = $res;
    }else{
        $opt_val = $options[$args['label_for']];
    }
    $msg = '';
    if($result['code'] == 200 && $result['expiry_date']  <= date("Y-m-d")){
        $color  = 'red';
        $msg    = $result['expiry_msg'];
    }
    else if($result['code'] > 200){
        $color  = 'red';
        $msg    = $result['msg'];
    }
    else{
        $color = 'inherit';
        $msg    = $result['msg'];
    }
    ?>
    <input type="text" id="<?php echo esc_attr( $args['label_for'] ); ?>"
           name="max_sb_location_geo_settings[<?php echo esc_attr( $args['label_for'] ); ?>]"
           value="<?php echo $opt_val; ?>" />
    <input type="button" data-ajaxurl="<?php echo admin_url('admin-ajax.php')?>" data-appurl="<?php echo get_home_url(); ?>" class="max_verify_license button button-success" value="Verify">
    <p class="max_license_response" style="color: <?php echo $color ; ?>">
        <?php
        if(isset($opt_val) && !empty($opt_val)){
            if(!empty($result) && $result != null && $result['code'] == 200 ){
                echo $msg;
            }else{
                if(isset($result['msg']) && $result['msg'] != ''){
                    echo $result['msg'];
                }else{
                    echo 'Please verify you license key';
                    ?>
                    <style>
                        .max_license_response{
                            color: red;
                        }
                    </style>
                    <?php
                }
            }
        }else{
            echo 'Please verify you license key';
            ?>
            <style>
                .max_license_response{
                    color: red;
                }
            </style>
            <?php
        }?>
    </p>
    <?php
}