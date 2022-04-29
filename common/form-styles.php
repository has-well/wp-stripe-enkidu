<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
* Trait: Form Settings Styles
*/
trait Wpsd_Form_Style_Settings
{
    protected $fields, $settings, $options;
    
    protected function wpsd_set_form_style_settings( $post ) {

        $this->fields   = $this->wpsd_form_style_option_fileds();

        $this->options  = $this->wpsd_build_set_settings_options( $this->fields, $post );

        $this->settings = apply_filters( 'wpsd_form_style_settings', $this->options, $post );

        return update_option( 'wpsd_form_style_settings', serialize( $this->settings ) );

    }

    protected function wpsd_get_form_style_settings() {

        $this->fields   = $this->wpsd_form_style_option_fileds();
		$this->settings = stripslashes_deep( unserialize( get_option('wpsd_form_style_settings') ) );
        
        return $this->wpsd_build_get_settings_options( $this->fields, $this->settings );
	}

    protected function wpsd_form_style_option_fileds() {

        return [
            [
                'name'      => 'wpsd_form_border_width',
                'type'      => 'number',
                'default'   => 0,
            ],
            [
                'name'      => 'wpsd_form_border_color',
                'type'      => 'text',
                'default'   => '#DDDDDD',
            ],
            [
                'name'      => 'wpsd_form_radius',
                'type'      => 'number',
                'default'   => 8,
            ],
            [
                'name'      => 'wpsd_form_padding_top',
                'type'      => 'number',
                'default'   => 0,
            ],
            [
                'name'      => 'wpsd_form_padding_right',
                'type'      => 'number',
                'default'   => 0,
            ],
            [
                'name'      => 'wpsd_form_padding_bottom',
                'type'      => 'number',
                'default'   => 0,
            ],
            [
                'name'      => 'wpsd_form_padding_left',
                'type'      => 'number',
                'default'   => 0,
            ],
            [
                'name'      => 'wpsd_form_bg_color',
                'type'      => 'text',
                'default'   => '#FFFFFF',
            ],
            [
                'name'      => 'wpsd_form_font_color',
                'type'      => 'text',
                'default'   => '#383838',
            ],
            [
                'name'      => 'wpsd_form_input_border_width',
                'type'      => 'number',
                'default'   => 1,
            ],
            [
                'name'      => 'wpsd_form_input_border_color',
                'type'      => 'text',
                'default'   => '#DDDDDD',
            ],
            [
                'name'      => 'wpsd_form_input_border_radius',
                'type'      => 'number',
                'default'   => 0,
            ],
            [
                'name'      => 'wpsd_form_input_padding_top',
                'type'      => 'number',
                'default'   => 10,
            ],
            [
                'name'      => 'wpsd_form_input_padding_right',
                'type'      => 'number',
                'default'   => 0,
            ],
            [
                'name'      => 'wpsd_form_input_padding_bottom',
                'type'      => 'number',
                'default'   => 10,
            ],
            [
                'name'      => 'wpsd_form_input_padding_left',
                'type'      => 'number',
                'default'   => 10,
            ],
            [
                'name'      => 'wpsd_form_input_bg_color',
                'type'      => 'text',
                'default'   => '#FFFFFF',
            ],
            [
                'name'      => 'wpsd_form_input_font_color',
                'type'      => 'text',
                'default'   => '#999',
            ],
            [
                'name'      => 'wpsd_form_input_font_size',
                'type'      => 'number',
                'default'   => '13',
            ],
            [
                'name'      => 'wpsd_button_bg_color',
                'type'      => 'text',
                'default'   => '#009900',
            ],
            [
                'name'      => 'wpsd_button_font_color',
                'type'      => 'text',
                'default'   => '#FFFFFF',
            ],
        ];
    }
}