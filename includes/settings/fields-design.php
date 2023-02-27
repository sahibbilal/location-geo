<?php

function max_fields_design(){
    add_settings_field(
        'max_sb_location_geo_heading_font_size',
        __( 'Heading Font Size', 'max_sb_location_geo' ),
        'max_sb_location_geo_heading_font_size_cb',
        'max_sb_location_geo',
        'max_sb_location_geo_design_styling',
        array(
            'label_for'         => 'max_sb_location_geo_heading_font_size',
            'class'             => 'max_sb_location_geo_row',
            'max_sb_location_geo_custom_data' => 'custom',
        )
    );

    add_settings_field(
        'max_sb_location_geo_heading_alignment',
        __( 'Heading Text Alignment', 'max_sb_location_geo' ),
        'max_sb_location_geo_heading_alignment_cb',
        'max_sb_location_geo',
        'max_sb_location_geo_design_styling',
        array(
            'label_for'         => 'max_sb_location_geo_heading_alignment',
            'class'             => 'max_sb_location_geo_row',
            'max_sb_location_geo_custom_data' => 'custom',
        )
    );

    add_settings_field(
        'max_sb_location_geo_heading_font_color',
        __( 'Heading Font Color', 'max_sb_location_geo' ),
        'max_sb_location_geo_heading_font_color_cb',
        'max_sb_location_geo',
        'max_sb_location_geo_design_styling',
        array(
            'label_for'         => 'max_sb_location_geo_heading_font_color',
            'class'             => 'max_sb_location_geo_row',
            'max_sb_location_geo_custom_data' => 'custom',
        )
    );

    add_settings_field(
        'max_sb_location_geo_paragraph_font_size',
        __( 'Paragprah Font Size', 'max_sb_location_geo' ),
        'max_sb_location_geo_paragraph_font_size_cb',
        'max_sb_location_geo',
        'max_sb_location_geo_design_styling',
        array(
            'label_for'         => 'max_sb_location_geo_paragraph_font_size',
            'class'             => 'max_sb_location_geo_row',
            'max_sb_location_geo_custom_data' => 'custom',
        )
    );

    add_settings_field(
        'max_sb_location_geo_paragraph_font_color',
        __( 'Paragprah Font Color', 'max_sb_location_geo' ),
        'max_sb_location_geo_paragraph_font_color_cb',
        'max_sb_location_geo',
        'max_sb_location_geo_design_styling',
        array(
            'label_for'         => 'max_sb_location_geo_paragraph_font_color',
            'class'             => 'max_sb_location_geo_row',
            'max_sb_location_geo_custom_data' => 'custom',
        )
    );


    add_settings_field(
        'max_sb_location_geo_margin_bottom',
        __( 'Margin', 'max_sb_location_geo' ),
        'max_sb_location_geo_margin_bottom_cb',
        'max_sb_location_geo',
        'max_sb_location_geo_design_spacing',
        array(
            'label_for'         => 'max_sb_location_geo_margin_bottom',
            'class'             => 'max_sb_location_geo_row',
            'max_sb_location_geo_custom_data' => 'custom',
        )
    );
    
}

function max_sb_location_geo_heading_font_color_cb( $args ){
    $options = get_option( 'max_sb_location_geo_options' );
    ?>
    <input type="text" class="color-picker" id="<?php echo esc_attr( $args['label_for'] ); ?>"
        name="max_sb_location_geo_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
        data-custom="<?php echo esc_attr( $args['max_sb_location_geo_custom_data'] ); ?>"
        value="<?php echo $options[$args['label_for']]; ?>" />
    <?php
 }
 
function max_sb_location_geo_heading_font_size_cb( $args ) {
    $options = get_option( 'max_sb_location_geo_options' );
    ?>
    <input type="number" id="<?php echo esc_attr( $args['label_for'] ); ?>"
        name="max_sb_location_geo_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
        data-custom="<?php echo esc_attr( $args['max_sb_location_geo_custom_data'] ); ?>"
        value="<?php echo $options[$args['label_for']]; ?>" />

    <p class="description">
        <?php esc_html_e( 'Define the font size value in Pixel (PX).', 'max_sb_location_geo' ); ?>
    </p>
    <?php
 }
 
 function max_sb_location_geo_paragraph_font_size_cb( $args ){
     $options = get_option( 'max_sb_location_geo_options' );
     ?>

    <input type="number" id="<?php echo esc_attr( $args['label_for'] ); ?>"
        name="max_sb_location_geo_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
        data-custom="<?php echo esc_attr( $args['max_sb_location_geo_custom_data'] ); ?>"
        value="<?php echo $options[$args['label_for']]; ?>" />

    <p class="description">
        <?php esc_html_e( 'Define the font size value in Pixel (PX).', 'max_sb_location_geo' ); ?>
    </p>
    <?php
}

function max_sb_location_geo_paragraph_font_color_cb( $args ){
     $options = get_option( 'max_sb_location_geo_options' );
     ?>
    <input type="text" class="color-picker" id="<?php echo esc_attr( $args['label_for'] ); ?>"
        name="max_sb_location_geo_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
        data-custom="<?php echo esc_attr( $args['max_sb_location_geo_custom_data'] ); ?>"
        value="<?php echo $options[$args['label_for']]; ?>" />
    <?php
}

function max_sb_location_geo_margin_bottom_cb($args){
    $options = get_option( 'max_sb_location_geo_options' );
    ?>
    <input type="number" id="<?php echo esc_attr( $args['label_for'] ); ?>"
        name="max_sb_location_geo_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
        data-custom="<?php echo esc_attr( $args['max_sb_location_geo_custom_data'] ); ?>"
        value="<?php echo $options[$args['label_for']]; ?>" />

    <p class="description">
        <?php esc_html_e( 'Define the spacing between components. The values define will be in pixels.', 'max_sb_location_geo' ); ?>
    </p>

    <?php
}

function max_sb_location_geo_heading_alignment_cb( $args ){
    $options = get_option( 'max_sb_location_geo_options' );
    ?>
    <select id="<?php echo esc_attr( $args['label_for'] ); ?>"
        name="max_sb_location_geo_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
        value="<?php echo $options[$args['label_for']]; ?>">
        <option value="left" <?php selected( $options['max_sb_location_geo_heading_alignment'], 'left' ); ?>>Left</option>
        <option value="center" <?php selected( $options['max_sb_location_geo_heading_alignment'], 'center' ); ?>>Center</option>
        <option value="right" <?php selected( $options['max_sb_location_geo_heading_alignment'], 'right' ); ?>>Right</option>
    </select>
    <?php
}