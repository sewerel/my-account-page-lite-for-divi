<?php

/**
 * Basic Call To Action module (title, content, and button) with FULL builder support which contains
 * all possible fields that can be used on 3rd party module
 * This module appears on Visual Builder and requires react component to be provided
 * Due to full builder support, all advanced options (except button options) are added by default
 *
 * @since 1.0.0
 */
class ClassicMyaccountModule extends ET_Builder_Module {
    // Module slug (also used as shortcode tag)
    public $slug       = 'classic_myaccount';

    // Visual Builder support.
    // Expected value: on|partial
    // - on:      you need to provide JS component for visual builder to render your content
    //            dynamically in visual builder
    // - partial: you don't need to provide JS component for visual builder to render your content
    //            divi will generate blank placeholder for your module instead
    public $vb_support = 'on';

    //Icon path used by parent class must be declared
    public $icon_path = '';

    // Module Credits (Appears at the bottom of the module settings modal)
    protected $module_credits = array(
        'module_uri' => 'https://divi-dev.site/my-extension',
        'author'     => 'Milen & Mariya',
        'author_uri' => 'https://divi-dev.site',
    );

    /**
     * Module properties initialization
     *
     * @since 1.0.0
     */
    function init() {
        // Module name
        $this->name             = 'My Account Classic';
        $this->main_css_element = '%%order_class%% .woocommerce';

        // Module Icon
        //$this->icon          = 'x';
        $this->icon_path        =  plugin_dir_path(__FILE__) . 'icon.svg';
    }

    public function get_fields() {
        $fields = [];
        $fields['__html'] = [
            'type'                => 'computed',
            'computed_callback'   => array('ClassicMyaccountModule', 'get_account_page_html'),
            'computed_depends_on' => array(
                'endpoint'
            )
        ];
        $fields['endpoint'] = [
            'label'            => 'Endpoint Preview',
            'type'             => 'select',
            'options'           => mapdl_get_endpoints_for_select(),
            'option_category'  => 'configuration',
            'toggle_slug'      => 'preview',
        ];

        //Layout
        $fields['layout_gap']  = [
            'label'             => 'Nav & content gap',
            'descriptions'      => 'Space between the Navogation and Content',
            'type'              => 'range',
            'range_settings'    => [
                'step'          => 1,
                'min'           => 0,
                'max'           => 100
            ],
            'default'           => '0px',
            'mobile_options'    => true,
            'responsive'        => true,
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'layout_toggle',
            'options_category'  => 'basic_option'
        ];
        $fields['equalize_columns']  = [
            'label'             => 'Equalize Nav & Content',
            'descriptions'      => 'Navigation and Content will display an equal height',
            'type'              => 'yes_no_button',
            'options'           => [
                'on'            => 'Yes',
                'off'           => 'No'
            ],
            'default'           => 'on',
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'layout_toggle',
            'options_category'  => 'basic_option'
        ];

        //*Nav Element toggle
        $fields['nav_padding']  = [
            'label'             => 'Navigation padding',
            'type'              => 'custom_margin',
            'mobile_options'    => true,
            'responsive'        => true,
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'nav_element_toggle',
            'options_category'  => 'basic_option',
            'default'           => '0|0|0|0||'
        ];
        $fields['nav_width']  = [
            'label'             => 'Navigation width',
            'type'              => 'range',
            'range_settings'    => [
                'step'          => 1,
                'min'           => 1,
                'max'           => 1000
            ],
            'default_unit'      => 'px',
            'mobile_options'    => true,
            'responsive'        => true,
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'nav_element_toggle',
            'options_category'  => 'basic_option'
        ];
        $fields['nav_breakpoint']  = [
            'label'             => 'Navigation breakpoint',
            'type'              => 'range',
            'range_settings'    => [
                'step'          => 1,
                'min'           => 300,
                'max'           => 2500
            ],
            'default'           => '980px',
            'tab_slug'          => 'general',
            'toggle_slug'       => 'breakpoint',
            'options_category'  => 'basic_option'
        ];
        $fields['nav_background']  = [
            'label'             => 'Navigation background',
            'type'              => 'color-alpha',
            'toggle_slug'       => 'nav_element_toggle',
            'tab_slug'          => 'advanced',
            'options_category'  => 'basic_option'
        ];


        //*Menu Item toggle
        $fields['nav_item_gap']  = [
            'label'             => 'Items gap',
            'descriptions'      => 'Space between the items',
            'type'              => 'range',
            'range_settings'    => [
                'step'          => 1,
                'min'           => 0,
                'max'           => 100
            ],
            'default'           => '0px',
            'mobile_options'    => true,
            'responsive'        => true,
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'nav_item_toggle',
            'options_category'  => 'basic_option'
        ];
        $fields['nav_item_icon_size']  = [
            'label'             => 'Icons size',
            'type'              => 'range',
            'range_settings'    => [
                'step'          => .1,
                'min'           => 0,
                'max'           => 100
            ],
            'default'           => '1em',
            'mobile_options'    => true,
            'responsive'        => true,
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'nav_item_toggle',
            'options_category'  => 'basic_option'
        ];
        $fields['nav_item_padding']  = [
            'label'             => 'Nav Item padding',
            'type'              => 'custom_margin',
            'mobile_options'    => true,
            'responsive'        => true,
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'nav_item_toggle',
            'options_category'  => 'basic_option',
            'default'           => '10px|20px|10px|20px|||'
        ];
        $fields['nav_item_background'] = [
            'label'             => 'Background',
            'type'              => 'color-alpha',
            'options_category'  => 'basic_option',
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'nav_item_toggle',
            'hover' => 'tabs'
        ];

        //*Menu Item Active toggle


        $fields['nav_item_active_background']  = [
            'label'             => 'Background',
            'type'              => 'color-alpha',
            'toggle_slug'       => 'nav_item_active_toggle',
            'tab_slug'          => 'advanced',
            'options_category'  => 'basic_option'
        ];

        //Endpoint content
        $fields['endpoint_content_padding']  = [
            'label'             => 'Endpoint padding',
            'type'              => 'custom_margin',
            'mobile_options'    => true,
            'responsive'        => true,
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'endpoint_content_toggle',
            'options_category'  => 'basic_option',
            'default'           => '30px|30px|30px|30px|||'
        ];
        $fields['endpoint_background']  = [
            'label'             => 'Background',
            'type'              => 'color-alpha',
            'options_category'  => 'basic_option',
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'endpoint_content_toggle'
        ];
        //Tables
        $fields['table_border_radius'] = [
            'label'             => 'Table Border Radius',
            'type'              => 'border-radius',
            'mobile_options'    => true,
            'responsive'        => true,
            'toggle_slug'       => 'tables_toggle',
            'tab_slug'          => 'advanced',
            'options_category'  => 'basic_option'
        ];
        $fields['table_border_width']  = [
            'label'             => 'Table border width',
            'descriptions'      => 'Width of the tables border',
            'type'              => 'range',
            'default_unit'      => 'px',
            'range_settings'    => [
                'step'          => 1,
                'min'           => 0,
                'max'           => 50
            ],
            'default'           => '1px',
            'toggle_slug'       => 'tables_toggle',
            'tab_slug'          => 'advanced',
            'options_category'  => 'basic_option'
        ];
        $fields['table_border_color']  = [
            'label'             => 'Table Border Color',
            'type'              => 'color-alpha',
            'toggle_slug'       => 'tables_toggle',
            'tab_slug'          => 'advanced',
            'options_category'  => 'basic_option'
        ];
        $fields['table_inner_border_width']  = [
            'label'             => 'Table row border width',
            'descriptions'      => 'Width of the table\'s rows border',
            'type'              => 'range',
            'default_unit'      => 'px',
            'range_settings'    => [
                'step'          => 1,
                'min'           => 0,
                'max'           => 50
            ],
            'default'           => '1px',
            'toggle_slug'       => 'tables_toggle',
            'tab_slug'          => 'advanced',
            'options_category'  => 'basic_option'
        ];
        $fields['table_inner_border_color']  = [
            'label'             => 'Table Rows Border Color',
            'type'              => 'color-alpha',
            'toggle_slug'       => 'tables_toggle',
            'tab_slug'          => 'advanced',
            'options_category'  => 'basic_option'
        ];
        $fields['table_composite'] = [
            'label'             => 'Background & Padding',
            'type'              => 'composite',
            'composite_type'    => 'default',
            'toggle_slug'       => 'tables_toggle',
            'tab_slug'          => 'advanced',
            'options_category'  => 'basic_option',
            'composite_structure' => [
                'head' => [
                    'label' => 'Head',
                    'controls' => [
                        'table_head_padding' => [
                            'label'             => 'Table Head Padding',
                            'type'              => 'custom_margin',
                            'mobile_options'    => true,
                            'responsive'        => true,
                            'options_category'  => 'basic_option',
                            'default'           => '0|0|0|0||'
                        ],
                        'table_head_background' => [
                            'label' => 'Table Head Background',
                            'type'  => 'color-alpha'
                        ]
                    ]
                ],
                'data' => [
                    'label' => 'Data',
                    'controls' => [
                        'table_data_padding' => [
                            'label'             => 'Table Data Padding',
                            'type'              => 'custom_margin',
                            'mobile_options'    => true,
                            'responsive'        => true,
                            'options_category'  => 'basic_option',
                            'default'           => '0|0|0|0||'
                        ],
                        'table_data_background' => [
                            'label' => 'Table Data Background',
                            'type'  => 'color-alpha'
                        ]
                    ]
                ],
                'odd' => [
                    'label' => 'Odd',
                    'controls' => [
                        'table_odd_background' => [
                            'label' => 'Odd Rows Background',
                            'type'  => 'color-alpha'
                        ]
                    ]
                ],
                'even' => [
                    'label' => 'even',
                    'controls' => [
                        'table_even_background' => [
                            'label' => 'Even Rows Background',
                            'type'  => 'color-alpha'
                        ]
                    ]
                ]

            ]
        ];
        //Notifications
        $fields['notice_background']  = [
            'label'             => 'Notice Background',
            'type'              => 'color-alpha',
            'toggle_slug'       => 'notifications_toggle',
            'tab_slug'          => 'advanced',
            'options_category'  => 'basic_option'
        ];
        $fields['notice_padding']  = [
            'label'             => 'Notice padding',
            'type'              => 'custom_margin',
            'mobile_options'    => true,
            'responsive'        => true,
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'notifications_toggle',
            'options_category'  => 'basic_option',
            'default'           => '15px|15px|15px|15px|||'
        ];
        //Forms
        $fields['form_fields_background'] = [
            'label'             => 'Form Fields Background',
            'type'              => 'color-alpha',
            'options_category'  => 'basic_option',
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'forms_toggle',
            'hover' => 'tabs'
        ];
        $fields['form_fields_custom_padding']  = [
            'label'             => 'Form Fields padding',
            'type'              => 'custom_margin',
            'mobile_options'    => true,
            'responsive'        => true,
            'hover'             => 'tabs',
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'forms_toggle',
            'options_category'  => 'basic_option',
            'default'           => '15px|15px|15px|15px|||'
        ];
        $fields['form_fields_border_radius'] = [
            'label'             => 'Form Fields border radius',
            'description'       => 'Adjust each border corner of the Form Fields, Hover will apply for Focus on the field',
            'type'              => 'border-radius',
            'mobile_options'    => true,
            'responsive'        => true,
            'hover'             => 'tabs',
            'toggle_slug'       => 'forms_toggle',
            'tab_slug'          => 'advanced',
            'options_category'  => 'basic_option'
        ];
        $fields['form_fields_composite'] = [
            'label'             => 'Form Fields borders',
            'type'              => 'composite',
            'composite_type'    => 'default',
            'toggle_slug'       => 'forms_toggle',
            'tab_slug'          => 'advanced',
            'options_category'  => 'border',
            'composite_structure' => [
                'all' => [
                    'icon'     => 'border-all',
                    'controls' => [
                        'form_fields_border_width' => [
                            'label' => 'Border Width',
                            'type'              => 'range',
                            'default_unit'      => 'px',
                            'hover' => 'tabs',
                            'range_settings'    => [
                                'step'          => 1,
                                'min'           => 0,
                                'max'           => 50
                            ],
                            'default'           => '0px',

                        ],
                        'form_fields_border_color' => [
                            'label' => 'Border Color',
                            'type'  => 'color-alpha',
                            'hover' => 'tabs'
                        ]
                    ]
                ],
                'top' => [
                    'icon'     => 'border-top',
                    'controls' => [
                        'form_fields_border_width_top' => [
                            'label' => 'Border Top Width',
                            'type'              => 'range',
                            'default_unit'      => 'px',
                            'hover' => 'tabs',
                            'range_settings'    => [
                                'step'          => 1,
                                'min'           => 0,
                                'max'           => 50
                            ],
                            'default'           => '0px',

                        ],
                        'form_fields_border_color_top' => [
                            'label' => 'Border Top Color',
                            'type'  => 'color-alpha',
                            'hover' => 'tabs'
                        ]
                    ]
                ],
                'right' => [
                    'icon'     => 'border-right',
                    'controls' => [
                        'form_fields_border_width_right' => [
                            'label' => 'Border Right Width',
                            'hover' => 'tabs',
                            'type'              => 'range',
                            'default_unit'      => 'px',
                            'range_settings'    => [
                                'step'          => 1,
                                'min'           => 0,
                                'max'           => 50
                            ],
                            'default'           => '0px',

                        ],
                        'form_fields_border_color_right' => [
                            'label' => 'Border Right Color',
                            'type'  => 'color-alpha',
                            'hover' => 'tabs'
                        ]
                    ]
                ],
                'bottom' => [
                    'icon'     => 'border-bottom',
                    'controls' => [
                        'form_fields_border_width_bottom' => [
                            'label' => 'Border Bottom Width',
                            'hover' => 'tabs',
                            'type'              => 'range',
                            'default_unit'      => 'px',
                            'range_settings'    => [
                                'step'          => 1,
                                'min'           => 0,
                                'max'           => 50
                            ],
                            'default'           => '0px',

                        ],
                        'form_fields_border_color_bottom' => [
                            'label' => 'Border Bottom Color',
                            'type'  => 'color-alpha',
                            'hover' => 'tabs'
                        ]
                    ]
                ],
                'left' => [
                    'icon'     => 'border-left',
                    'controls' => [
                        'form_fields_border_width_left' => [
                            'label' => 'Border Left Width',
                            'hover' => 'tabs',
                            'type'              => 'range',
                            'default_unit'      => 'px',
                            'range_settings'    => [
                                'step'          => 1,
                                'min'           => 0,
                                'max'           => 50
                            ],
                            'default'           => '0px',

                        ],
                        'form_fields_border_color_left' => [
                            'label' => 'Border Left Color',
                            'type'  => 'color-alpha',
                            'hover' => 'tabs'
                        ]
                    ]
                ],

            ]
        ];

        return $fields;
    }
    public function get_advanced_fields_config() {
        $adv_fields = [];
        $adv_fields['fonts']['default'] = [

            'label'           => 'Paragraph',
            'css'             => array(
                'main'  => "%%order_class%% .divi_map-endpoint-content p",
                'hover' => "%%order_class%% .divi_map-endpoint-content p:hover",
            ),
            'sub_toggle'     => 'p',
            'toggle_slug'   => 'endpoint_font_toggle',
            'tab_slug'      => 'advanced',
            'hide_text_align'     =>  true,
            'hide_text_shadow'     =>  true,
        ];
        $adv_fields['fonts']['endpoint_link'] = [

            'label'           => 'Link',
            'css'             => array(
                'main'  => "%%order_class%% .divi_map-endpoint-content a:not(.button)",
                'hover' => "%%order_class%% .divi_map-endpoint-content a:not(.button):hover",
            ),
            'sub_toggle'    => 'a',
            'toggle_slug'   => 'endpoint_font_toggle',
            'tab_slug'      => 'advanced',
            'hide_text_align'     =>  true,
            'hide_text_shadow'     =>  true,
        ];
        $adv_fields['fonts']['endpoint_h2'] = [

            'label'           => 'h2',
            'css'             => array(
                'main'  => "%%order_class%% .divi_map-endpoint-content h2",
                'hover' => "%%order_class%% .divi_map-endpoint-content h2:hover",
            ),
            'sub_toggle'    => 'h2',
            'toggle_slug'   => 'endpoint_font_toggle',
            'tab_slug'      => 'advanced',
            'hide_text_align'     =>  true,
            'hide_text_shadow'     =>  true,
        ];
        $adv_fields['fonts']['endpoint_h3'] = [

            'label'           => 'h3',
            'css'             => array(
                'main'  => "%%order_class%% .divi_map-endpoint-content h3",
                'hover' => "%%order_class%% .divi_map-endpoint-content h3:hover",
            ),
            'sub_toggle'    => 'h3',
            'toggle_slug'   => 'endpoint_font_toggle',
            'tab_slug'      => 'advanced',
            'hide_text_align'     =>  true,
            'hide_text_shadow'     =>  true,
        ];
        $adv_fields['fonts']['tables_head'] = [

            'label'           => 'Table Header',
            'css'             => array(
                'main'  => "{$this->main_css_element} .divi_map-endpoint-content thead th",
                'hover' => "{$this->main_css_element} .divi_map-endpoint-content thead th:hover",
            ),
            'sub_toggle'    => 'table_head',
            'toggle_slug'   => 'endpoint_table_font',
            'tab_slug'      => 'advanced',
            'hide_text_shadow'     =>  true,
        ];
        $adv_fields['fonts']['tables_content'] = [

            'label'           => 'Table Data',
            'css'             => array(
                'main'  => "{$this->main_css_element} .divi_map-endpoint-content table td,{$this->main_css_element} .divi_map-endpoint-content tbody th",
                'hover' => "{$this->main_css_element} .divi_map-endpoint-content table td:hover,{$this->main_css_element} .divi_map-endpoint-content tbody th:hover",
            ),
            'sub_toggle'    => 'table_data',
            'toggle_slug'   => 'endpoint_table_font',
            'tab_slug'      => 'advanced',
            'hide_text_shadow'   =>  true,
        ];
        $adv_fields['fonts']['nav_item_font'] = [

            'label'           => 'Nav Item',
            'css'             => array(
                'main'  => "%%order_class%% .divi_map-woocommerce-MyAccount-navigation li a",
                'hover' => "%%order_class%% .divi_map-woocommerce-MyAccount-navigation li a:hover",
            ),
            'hide_text_align'     =>  true,
            'hide_text_shadow'     =>  true,
            'toggle_slug'   => 'nav_item_toggle',
            'tab_slug'      => 'advanced',
        ];
        $adv_fields['fonts']['notice_font'] = [

            'label'           => 'Notice',
            'css'             => array(
                'important' => 'all',
                'main'  => "%%order_class%% .woocommerce .woocommerce-info,%%order_class%% .woocommerce .woocommerce-error,%%order_class%% .woocommerce .woocommerce-message",
                'hover' => "%%order_class%% .woocommerce .woocommerce-info:hover,.woocommerce .woocommerce-error:hover,%%order_class%% .woocommerce .woocommerce-message:hover",
            ),
            'hide_text_align'     =>  true,
            'hide_text_shadow'     =>  true,
            'toggle_slug'   => 'notifications_toggle',
            'tab_slug'      => 'advanced',
        ];
        $adv_fields['fonts']['nav_item_active_font'] = [

            'label'           => 'Active Item',
            'css'             => array(
                'main'  => "%%order_class%% .divi_map-woocommerce-MyAccount-navigation li.tab_selected a",
                'hover' => "%%order_class%% .divi_map-woocommerce-MyAccount-navigation li.tab_selected a:hover",
            ),
            'hide_text_align'     =>  true,
            'hide_text_shadow'     =>  true,
            'toggle_slug'   => 'nav_item_active_toggle',
            'tab_slug'      => 'advanced',
        ];
        $adv_fields['fonts']['form_labels'] = [

            'label'           => 'Form Labels',
            'css'             => array(
                'main'  => "%%order_class%% .woocommerce .divi_map-endpoint-content form label",
                'hover' => "%%order_class%% .woocommerce .divi_map-endpoint-content form label:hover",
            ),
            'hide_text_align'     =>  true,
            'hide_text_shadow'     =>  true,
            'toggle_slug'   => 'forms_toggle',
            'tab_slug'      => 'advanced',
        ];
        $adv_fields['fonts']['form_fields'] = [

            'label'           => 'Form Fields',
            'css'             => array(
                'main'  => "%%order_class%% .woocommerce .divi_map-endpoint-content form input",
                'hover' => "%%order_class%% .woocommerce .divi_map-endpoint-content form input:focus",
            ),
            'hide_text_align'     =>  true,
            'hide_text_shadow'     =>  true,
            'toggle_slug'   => 'forms_toggle',
            'tab_slug'      => 'advanced',
        ];
        $adv_fields['box_shadow']['default']  = [
            'label'             => 'Navigation box Shadow',
            'css'               => [
                'main'          => '%%order_class%% .divi_map-woocommerce-MyAccount-navigation'
            ],
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'nav_element_toggle',
            'hover'             => 'tabs'
        ];
        $adv_fields['box_shadow']['nav_item'] = [
            'label'             => 'Nav Item Shadow',
            'css'               => [
                'main'          => '%%order_class%% .divi_map-woocommerce-MyAccount-navigation li a',
                'hover'          => '%%order_class%% .divi_map-woocommerce-MyAccount-navigation li a:hover'
            ],
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'nav_item_toggle',
            'hover'             => 'tabs'
        ];
        $adv_fields['box_shadow']['content'] = [
            'label'             => 'Content box Shadow',
            'css'               => [
                'main'          => '%%order_class%% .divi_map-endpoint-content'
            ],
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'endpoint_content_toggle',
            'hover'             => 'tabs'
        ];
        $adv_fields['box_shadow']['notice'] = [
            'label'             => 'Nofication box Shadow',
            'css'               => [
                'main'          => '%%order_class%% .divi_map-endpoint-content .woocommerce-info,%%order_class%% .divi_map-endpoint-content .woocommerce-error,%%order_class%% .divi_map-endpoint-content .woocommerce-message',
                'important'     => 'all'
            ],
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'notifications_toggle',
        ];
        $adv_fields['button']['table_button'] = [
            'label'     => 'Table buttons',
            'css'       => [
                'main'  => '%%order_class%% .woocommerce .divi_map-endpoint-content table .button',
                'hover'  => '%%order_class%% .woocommerce .divi_map-endpoint-content table .button:hover',
                'important' => 'all'
            ],
            'hide_icon'     => true,
            'use_alignment' => false,
            'box_shadow'    => [
                'css'   => [
                    'main' => '%%order_class%% .divi_map-endpoint-content table .button',
                    'hover' => '%%order_class%% .divi_map-endpoint-content table .button:hover',
                ]
            ],
            'no_rel_attr'   => true,
            'toggle_slug'   => 'tables_toggle',
            'tab_slug'      => 'advanced'
        ];
        $adv_fields['button']['notice_button'] = [
            'label'     => 'Notice buttons',
            'css'       => [
                'main'  => '%%order_class%% .woocommerce .divi_map-endpoint-content .woocommerce-info .button',
                'hover'  => '%%order_class%% .woocommerce .divi_map-endpoint-content .woocommerce-info .button:hover'
            ],
            'hide_icon'     => true,
            'use_alignment' => false,
            'box_shadow'    => [
                'css'   => [
                    'main' => '%%order_class%% .divi_map-endpoint-content .woocommerce-info .button',
                    'hover' => '%%order_class%% .divi_map-endpoint-content .woocommerce-info .button:hover',
                ]
            ],
            'no_rel_attr'   => true,
            'toggle_slug'   => 'notifications_toggle',
            'tab_slug'      => 'advanced'
        ];
        $adv_fields['button']['form_button'] = [
            'label'     => 'Form buttons',
            'css'       => [
                'main'  => '%%order_class%% .divi_map-endpoint-content form button:not(.show-password-input),%%order_class%% .divi_map-endpoint-content>.button,%%order_class%% .divi_map-endpoint-content .order-again .button',
                'hover'  => '%%order_class%% .divi_map-endpoint-content form button:not(.show-password-input):hover,%%order_class%% .divi_map-endpoint-content>.button:hover,%%order_class%% .divi_map-endpoint-content .order-again .button:hover',
                'important' => 'all'
            ],
            'hide_icon'     => true,
            'use_alignment' => false,
            'box_shadow'    => [
                'css'   => [
                    'main' => '%%order_class%% .divi_map-endpoint-content form button:not(.show-password-input),%%order_class%% .woocommerce .divi_map-endpoint-content>.button',
                    'hover' => '%%order_class%% .divi_map-endpoint-content form button:not(.show-password-input):hover,%%order_class%% .woocommerce .divi_map-endpoint-content>.button:hover',
                ]
            ],
            'no_rel_attr'   => true,
            'toggle_slug'   => 'forms_toggle',
            'tab_slug'      => 'advanced'
        ];
        // $adv_fields['button']['form_fields'] = [
        //     'label'     => 'Forms fields',
        //     'description' => 'Customize form fields',
        //     'css'       => [
        //         'main'  => '%%order_class%% .woocommerce .divi_map-endpoint-content form input',
        //         'hover'  => '%%order_class%% .woocommerce .divi_map-endpoint-content form input:focus'
        //     ],
        //     'background-field' => [
        //         'css' => [
        //             'hover' => '%%order_class%% .woocommerce .divi_map-endpoint-content form input:focus'
        //         ]
        //     ],
        //     'hide_icon'     => true,
        //     'use_alignment' => false,
        //     'box_shadow'    => false,
        //     'no_rel_attr'   => true,
        //     'toggle_slug'   => 'forms_toggle',
        //     'tab_slug'      => 'advanced'
        // ];

        $adv_fields['borders']['default']          = false;
        $adv_fields['borders']['nav_border']    = [
            'label' => 'Nav Border',
            'css'             => array(
                'main' => array(
                    'border_radii' => "%%order_class%% .divi_map-woocommerce-MyAccount-navigation",
                    'border_styles' => "%%order_class%% .divi_map-woocommerce-MyAccount-navigation"
                )

            ),
            'label_prefix'   => 'Navigation',
            'toggle_slug'   => 'nav_element_toggle',
            'tab_slug'      => 'advanced'
        ];
        $adv_fields['borders']['nav_item_border']    = [
            'label' => 'Nav Item Border',
            'css'             => array(
                'main' => array(
                    'border_radii' => "%%order_class%% .divi_map-woocommerce-MyAccount-navigation li a",
                    'border_styles' => "%%order_class%% .divi_map-woocommerce-MyAccount-navigation li a",
                )
            ),
            'label_prefix'  => 'Nav Item',
            'toggle_slug'   => 'nav_item_toggle',
            'tab_slug'      => 'advanced'
        ];
        $adv_fields['borders']['nav_item_active_border']    = [
            'label' => 'Nav Item Border',
            'css'             => array(
                'main' => array(
                    'border_radii' => "%%order_class%% .divi_map-woocommerce-MyAccount-navigation li.tab_selected a",
                    'border_styles' => "%%order_class%% .divi_map-woocommerce-MyAccount-navigation li.tab_selected a",
                )
            ),
            'label_prefix'  => 'Nav Item',
            'toggle_slug'   => 'nav_item_active_toggle',
            'tab_slug'      => 'advanced'
        ];
        $adv_fields['borders']['notice_border']    = [
            'label' => 'Notice',
            'css'             => array(
                'main' => array(
                    'border_radii' => "%%order_class%% .divi_map-endpoint-content .woocommerce-info,%%order_class%% .divi_map-endpoint-content .woocommerce-error,%%order_class%% .divi_map-endpoint-content .woocommerce-message",
                    'border_styles' => "%%order_class%% .divi_map-endpoint-content .woocommerce-info,%%order_class%% .divi_map-endpoint-content .woocommerce-error,%%order_class%% .divi_map-endpoint-content .woocommerce-message",
                )
            ),
            'label_prefix'  => 'Notice',
            'toggle_slug'   => 'notifications_toggle',
            'tab_slug'      => 'advanced'
        ];


        $adv_fields['text']             = false;
        $adv_fields['filters']          = false;
        $adv_fields['text_shadow']      = false;
        $adv_fields['link_options']     = false;
        $adv_fields['max_width']        = false;
        $adv_fields['margin_padding']   = false;

        return $adv_fields;
    }
    public function get_settings_modal_toggles() {
        $toggles = [];
        $toggles['general'] = [
            'toggles' => [
                'breakpoint' => 'Breakpoint',
                'preview' => 'Endpoint Preview'
            ]
        ];
        $toggles['advanced'] = [
            'toggles'   => [
                'layout_toggle' => [
                    'title' => 'Layout',
                ],
                'nav_element_toggle' => [
                    'title' => 'Navigation',
                ],
                'nav_item_toggle' => [
                    'title' => 'Navigation Item',
                ],
                'nav_item_active_toggle' => [
                    'title' => 'Navigation Item Active',
                ],
                'endpoint_content_toggle' => [
                    'title' => 'Endpoint Content',
                ],
                'endpoint_font_toggle' => [
                    'title' => 'Endpoint Text',
                    'tabbed_subtoggles' => true,
                    'bb_icons_support'  => true,
                    'sub_toggles'       => array(
                        'p'     => array(
                            'name' => 'P',
                            'icon' => 'text-left',
                        ),
                        'a'     => array(
                            'name' => 'A',
                            'icon' => 'text-link',
                        ),
                        'h2'     => array(
                            'name' => 'H2'
                        ),
                        'h3'     => array(
                            'name' => 'H3',
                        )
                    )
                ],
                'tables_toggle' => [
                    'title' => 'Tables',
                ],
                'endpoint_table_font' => [
                    'title' => 'Table Text',
                    'tabbed_subtoggles' => true,
                    'sub_toggles'       => array(
                        'table_head'     => [
                            'name' => 'Head'
                        ],
                        'table_data'     => [
                            'name' => 'Data'
                        ],
                    )
                ],
                'notifications_toggle' => [
                    'title' => 'Notifications',
                ],
                'forms_toggle' => [
                    'title' => 'Forms',
                ]
            ]

        ];

        return $toggles;
    }
    public function set_responsivness($value, $selector, $property, $render_slug, $split = false, $start = 0, $important = '') {
        if ($split) {
            if (isset($this->props[$value]) && $this->props[$value] !== '') {
                $splited_values = explode('|', $this->props[$value]);
                $declaration = '';
                $declaration .= !empty($splited_values[$start]) ? "{$property[0]}:{$splited_values[$start]}{$important};" : '';
                $declaration .= !empty($splited_values[$start + 1]) ? "{$property[1]}:{$splited_values[$start + 1]}{$important};" : '';
                $declaration .= !empty($splited_values[$start + 2]) ? "{$property[2]}:{$splited_values[$start + 2]}{$important};" : '';
                $declaration .= !empty($splited_values[$start + 3]) ? "{$property[3]}:{$splited_values[$start + 3]}{$important};" : '';
                if (!empty($declaration)) {
                    ET_Builder_Element::set_style($render_slug, [
                        'selector'  => $selector,
                        'declaration'  => $declaration
                    ]);
                }
            }
            if (isset($this->props[$value . '_tablet']) &&  $this->props[$value . '_tablet'] !== '') {
                $splited_values_tablet = explode('|', $this->props[$value . '_tablet']);
                $declaration_tablet = '';
                $declaration_tablet .= !empty($splited_values_tablet[$start]) ? "{$property[0]}:{$splited_values_tablet[$start]}{$important};" : '';
                $declaration_tablet .= !empty($splited_values_tablet[$start + 1]) ? "{$property[1]}:{$splited_values_tablet[$start + 1]}{$important};" : '';
                $declaration_tablet .= !empty($splited_values_tablet[$start + 2]) ? "{$property[2]}:{$splited_values_tablet[$start + 2]}{$important};" : '';
                $declaration_tablet .= !empty($splited_values_tablet[$start + 3]) ? "{$property[3]}:{$splited_values_tablet[$start + 3]}{$important};" : '';
                if (!empty($declaration_tablet)) {

                    ET_Builder_Element::set_style($render_slug, [
                        'selector'  => $selector,
                        'declaration'   => $declaration_tablet,
                        'media_query'   => ET_Builder_Element::get_media_query("max_width_980")
                    ]);
                }
            }
            if (isset($this->props[$value . '_phone']) && $this->props[$value . '_phone'] !== '') {
                $splited_values_phone = explode('|', $this->props[$value . '_phone']);
                $declaration_phone = '';
                $declaration_phone .= !empty($splited_values_phone[$start]) ? "{$property[0]}:{$splited_values_phone[$start]}{$important};" : '';
                $declaration_phone .= !empty($splited_values_phone[$start + 1]) ? "{$property[1]}:{$splited_values_phone[$start + 1]}{$important};" : '';
                $declaration_phone .= !empty($splited_values_phone[$start + 2]) ? "{$property[2]}:{$splited_values_phone[$start + 2]}{$important};" : '';
                $declaration_phone .= !empty($splited_values_phone[$start + 3]) ? "{$property[3]}:{$splited_values_phone[$start + 3]}{$important};" : '';
                if (!empty($declaration_phone)) {
                    ET_Builder_Element::set_style($render_slug, [
                        'selector'  => $selector,
                        'declaration'   => $declaration_phone,
                        'media_query'   => ET_Builder_Element::get_media_query("max_width_767")
                    ]);
                }
            }
        } else {
            if (isset($this->props[$value]) && $this->props[$value] !== '') {
                $declaration = "{$property}:{$this->props[$value]}{$important};";
                ET_Builder_Element::set_style($render_slug, [
                    'selector'  => $selector,
                    'declaration'   => $declaration
                ]);
            }
            if (isset($this->props[$value . '_tablet']) && $this->props[$value . '_tablet'] !== '') {
                $declaration_tablet = "{$property}:{$this->props[$value . '_tablet']}{$important};";
                ET_Builder_Element::set_style($render_slug, [
                    'selector'  => $selector,
                    'declaration'   => $declaration_tablet,
                    'media_query'   => ET_Builder_Element::get_media_query("max_width_980")
                ]);
            }
            if (isset($this->props[$value . '_phone']) && $this->props[$value . '_phone'] !== '') {
                $declaration_phone = "{$property}:{$this->props[$value . '_phone']}{$important};";
                ET_Builder_Element::set_style($render_slug, [
                    'selector'  => $selector,
                    'declaration'   => $declaration_phone,
                    'media_query'   => ET_Builder_Element::get_media_query("max_width_767")
                ]);
            }
        }
    }
    public function set_styles($render_slug) {
        //Breakpoint
        if (isset($this->props['equalize_columns']) && $this->props['equalize_columns'] == 'off') {
            ET_Builder_Element::set_style($render_slug, [
                'selector'  => "%%order_class%% .divi_map-MyAccount-wrap",
                'declaration'   => "align-items:flex-start;"
            ]);
        }
        //Layout
        if (isset($this->props['nav_breakpoint'])) {
            ET_Builder_Element::set_style($render_slug, [
                'selector'  => "%%order_class%% .divi_map-MyAccount-wrap",
                'declaration'   => "flex-direction:column;",
                'media_query'  => "@media only screen and ( max-width: {$this->props['nav_breakpoint']} )"
            ]);
            ET_Builder_Element::set_style($render_slug, [
                'selector'  => "%%order_class%% .divi_map-MyAccount-wrap>nav, %%order_class%% .divi_map-MyAccount-wrap .woocommerce-MyAccount-content",
                'declaration'   => "width:100%;",
                'media_query'  => "@media only screen and ( max-width: {$this->props['nav_breakpoint']} )"
            ]);
        }
        $this->set_responsivness(
            'layout_gap',
            '%%order_class%% .divi_map-MyAccount-wrap',
            'gap',
            $render_slug
        );
        //Navigation
        $this->set_responsivness(
            'nav_padding',
            '%%order_class%% .divi_map-woocommerce-MyAccount-navigation',
            ['padding-top', 'padding-right', 'padding-bottom', 'padding-left'],
            $render_slug,
            true,
            0
        );
        $this->set_responsivness(
            'nav_width',
            '%%order_class%% .divi_map-woocommerce-MyAccount-navigation',
            "width",
            $render_slug
        );
        $this->set_responsivness(
            'nav_background',
            '%%order_class%% .divi_map-woocommerce-MyAccount-navigation',
            "background-color",
            $render_slug
        );

        //Navigation Item
        $this->set_responsivness(
            'nav_item_icon_size',
            '%%order_class%% .divi_map-woocommerce-MyAccount-navigation .divi_map-icon-wrap',
            'font-size',
            $render_slug
        );
        $this->set_responsivness(
            'nav_item_gap',
            '%%order_class%% .divi_map-woocommerce-MyAccount-navigation ul',
            'gap',
            $render_slug
        );
        $this->set_responsivness(
            'nav_item_padding',
            '%%order_class%% .divi_map-woocommerce-MyAccount-navigation li a',
            ['padding-top', 'padding-right', 'padding-bottom', 'padding-left'],
            $render_slug,
            true,
            0
        );
        $this->set_responsivness(
            'nav_item_background',
            '%%order_class%% .divi_map-woocommerce-MyAccount-navigation li a',
            'background-color',
            $render_slug
        );
        $this->set_responsivness(
            'nav_item_background__hover',
            '%%order_class%% .divi_map-woocommerce-MyAccount-navigation li a:hover',
            'background-color',
            $render_slug
        );
        //Navigation Active Item
        $this->set_responsivness(
            'nav_item_active_background',
            '%%order_class%% .divi_map-woocommerce-MyAccount-navigation li.tab_selected a',
            'background-color',
            $render_slug
        );

        // Endpoint content
        $this->set_responsivness(
            'endpoint_content_padding',
            '%%order_class%% .divi_map-endpoint-content',
            ['padding-top', 'padding-right', 'padding-bottom', 'padding-left'],
            $render_slug,
            true,
            0
        );
        $this->set_responsivness(
            'endpoint_background',
            '%%order_class%% .divi_map-endpoint-content',
            'background-color',
            $render_slug
        );
        //Tables
        $this->set_responsivness(
            'table_border_radius',
            '%%order_class%% .woocommerce .divi_map-endpoint-content table',
            ['border-top-left-radius', 'border-top-right-radius', 'border-bottom-right-radius', 'border-bottom-left-radius'],
            $render_slug,
            true,
            1
        );
        $this->set_responsivness(
            'table_tables_toggle',
            '%%order_class%% .woocommerce .divi_map-endpoint-content table',
            'border-width',
            $render_slug
        );
        $this->set_responsivness(
            'table_border_color',
            '%%order_class%% .woocommerce .divi_map-endpoint-content table',
            'border-color',
            $render_slug
        );
        $this->set_responsivness(
            'table_border_width',
            '%%order_class%% .woocommerce .divi_map-endpoint-content table',
            'border-width',
            $render_slug
        );
        $this->set_responsivness(
            'table_inner_border_width',
            '%%order_class%% .divi_map-endpoint-content tbody th,%%order_class%% .divi_map-endpoint-content table td,%%order_class%% .divi_map-endpoint-content tfoot th',
            'border-top-width',
            $render_slug,
            false,
            0,
            '!important'
        );
        $this->set_responsivness(
            'table_inner_border_color',
            '%%order_class%% .divi_map-endpoint-content tbody th,%%order_class%% .divi_map-endpoint-content table td,%%order_class%% .divi_map-endpoint-content tfoot th',
            'border-top-color',
            $render_slug,
            false,
            0,
            '!important'
        );

        $this->set_responsivness(
            'table_head_padding',
            '%%order_class%% .woocommerce .divi_map-endpoint-content thead th',
            ['padding-top', 'padding-right', 'padding-bottom', 'padding-left'],
            $render_slug,
            true,
            0
        );
        $this->set_responsivness(
            'table_head_background',
            '%%order_class%% .divi_map-endpoint-content thead th,%%order_class%% .divi_map-endpoint-content table tfoot',
            'background-color',
            $render_slug
        );
        $this->set_responsivness(
            'table_data_padding',
            '%%order_class%% .woocommerce .divi_map-endpoint-content table td,%%order_class%% .woocommerce .divi_map-endpoint-content tbody th',
            ['padding-top', 'padding-right', 'padding-bottom', 'padding-left'],
            $render_slug,
            true,
            0
        );
        $this->set_responsivness(
            'table_data_background',
            '%%order_class%% .woocommerce .divi_map-endpoint-content table tbody',
            'background-color',
            $render_slug
        );
        $this->set_responsivness(
            'table_odd_background',
            '%%order_class%% .woocommerce .divi_map-endpoint-content table tbody tr:nth-child(odd)',
            'background-color',
            $render_slug
        );
        $this->set_responsivness(
            'table_even_background',
            '%%order_class%% .woocommerce .divi_map-endpoint-content table tbody tr:nth-child(even)',
            'background-color',
            $render_slug
        );
        $this->set_responsivness(
            'notice_padding',
            '%%order_class%% .divi_map-endpoint-content .woocommerce-info,%%order_class%% .divi_map-endpoint-content .woocommerce-error,%%order_class%% .divi_map-endpoint-content .woocommerce-message',
            ['padding-top', 'padding-right', 'padding-bottom', 'padding-left'],
            $render_slug,
            true,
            0,
            '!important'
        );
        $this->set_responsivness(
            'notice_background',
            '%%order_class%% .divi_map-endpoint-content .woocommerce-info,%%order_class%% .divi_map-endpoint-content .woocommerce-error,%%order_class%% .divi_map-endpoint-content .woocommerce-message',
            'background-color',
            $render_slug,
            false,
            0,
            '!important'
        );
        //Table button padding
        $this->set_responsivness(
            'table_button_custom_padding',
            '%%order_class%% .woocommerce .divi_map-endpoint-content table .button',
            ['padding-top', 'padding-right', 'padding-bottom', 'padding-left'],
            $render_slug,
            true,
            0,
            '!important'
        );
        $this->set_responsivness(
            'table_button_custom_padding__hover',
            '%%order_class%% .woocommerce .divi_map-endpoint-content table .button:hover',
            ['padding-top', 'padding-right', 'padding-bottom', 'padding-left'],
            $render_slug,
            true,
            0,
            '!important'
        );
        //Notice button padding
        $this->set_responsivness(
            'notice_button_custom_padding',
            '%%order_class%% .divi_map-endpoint-content div[class^="woocommerce-"] .button',
            ['padding-top', 'padding-right', 'padding-bottom', 'padding-left'],
            $render_slug,
            true,
            0,
            '!important'
        );
        $this->set_responsivness(
            'notice_button_custom_padding__hover',
            '%%order_class%% .woocommerce .divi_map-endpoint-content div[class^="woocommerce-"] .button:hover',
            ['padding-top', 'padding-right', 'padding-bottom', 'padding-left'],
            $render_slug,
            true,
            0,
            '!important'
        );
        //Form button padding
        $this->set_responsivness(
            'form_button_custom_padding',
            'body #page-container %%order_class%% .divi_map-endpoint-content form button,body #page-container %%order_class%% .divi_map-endpoint-content>.button,body #page-container %%order_class%% .divi_map-endpoint-content .order-again .button',
            ['padding-top', 'padding-right', 'padding-bottom', 'padding-left'],
            $render_slug,
            true,
            0,
            '!important'
        );
        $this->set_responsivness(
            'form_button_custom_padding__hover',
            'body #page-container %%order_class%% .divi_map-endpoint-content form button:hover,body #page-container %%order_class%% .divi_map-endpoint-content>.button:hover,body #page-container %%order_class%% .divi_map-endpoint-content .order-again .button:hover',
            ['padding-top', 'padding-right', 'padding-bottom', 'padding-left'],
            $render_slug,
            true,
            0,
            '!important'
        );
        //Form fields padding
        $this->set_responsivness(
            'form_fields_background',
            '%%order_class%% .divi_map-endpoint-content form input',
            'background-color',
            $render_slug,
            false,
            0,
            '!important'
        );
        $this->set_responsivness(
            'form_fields_background__hover',
            '%%order_class%% .divi_map-endpoint-content form input:focus',
            'background-color',
            $render_slug,
            false,
            0,
            '!important'
        );
        $this->set_responsivness(
            'form_fields_custom_padding',
            '%%order_class%% .woocommerce .divi_map-endpoint-content form input',
            ['padding-top', 'padding-right', 'padding-bottom', 'padding-left'],
            $render_slug,
            true,
            0,
            '!important'
        );
        $this->set_responsivness(
            'form_fields_custom_padding__hover',
            '%%order_class%% .woocommerce .divi_map-endpoint-content form input:focus',
            ['padding-top', 'padding-right', 'padding-bottom', 'padding-left'],
            $render_slug,
            true,
            0,
            '!important'
        );

        // * Form fields Border
        $this->set_responsivness(
            'form_fields_border_radius',
            '%%order_class%% .divi_map-endpoint-content form input',
            ['border-top-left-radius', 'border-top-right-radius', 'border-bottom-right-radius', 'border-bottom-left-radius'],
            $render_slug,
            true,
            1,
            '!important'
        );
        $this->set_responsivness(
            'form_fields_border_radius__hover',
            '%%order_class%% .divi_map-endpoint-content form input:focus',
            ['border-top-left-radius', 'border-top-right-radius', 'border-bottom-right-radius', 'border-bottom-left-radius'],
            $render_slug,
            true,
            1,
            '!important'
        );
        $this->set_responsivness(
            'form_fields_border_width',
            '%%order_class%% .divi_map-endpoint-content form input',
            "border-width",
            $render_slug,
            false,
            0,
            '!important'
        );
        $this->set_responsivness(
            'form_fields_border_width__hover',
            '%%order_class%% .divi_map-endpoint-content form input:focus',
            "border-width",
            $render_slug,
            false,
            0,
            '!important'
        );
        $this->set_responsivness(
            'form_fields_border_color',
            '%%order_class%% .divi_map-endpoint-content form input',
            "border-color",
            $render_slug,
            false,
            0,
            '!important'
        );
        $this->set_responsivness(
            'form_fields_border_color__hover',
            '%%order_class%% .divi_map-endpoint-content form input:focus',
            "border-color",
            $render_slug,
            false,
            0,
            '!important'
        );
        $this->set_responsivness(
            'form_fields_border_width_top',
            '%%order_class%% .divi_map-endpoint-content form input',
            "border-top-width",
            $render_slug,
            false,
            0,
            '!important'
        );
        $this->set_responsivness(
            'form_fields_border_width_top__hover',
            '%%order_class%% .divi_map-endpoint-content form input:focus',
            "border-top-width",
            $render_slug,
            false,
            0,
            '!important'
        );
        $this->set_responsivness(
            'form_fields_border_color_top',
            '%%order_class%% .divi_map-endpoint-content form input',
            "border-top-color",
            $render_slug,
            false,
            0,
            '!important'
        );
        $this->set_responsivness(
            'form_fields_border_color_top__hover',
            '%%order_class%% .divi_map-endpoint-content form input:focus',
            "border-top-color",
            $render_slug,
            false,
            0,
            '!important'
        );
        $this->set_responsivness(
            'form_fields_border_width_right',
            '%%order_class%% .divi_map-endpoint-content form input',
            "border-right-width",
            $render_slug,
            false,
            0,
            '!important'
        );
        $this->set_responsivness(
            'form_fields_border_width_right__hover',
            '%%order_class%% .divi_map-endpoint-content form input:focus',
            "border-right-width",
            $render_slug,
            false,
            0,
            '!important'
        );
        $this->set_responsivness(
            'form_fields_border_color_right',
            '%%order_class%% .divi_map-endpoint-content form input',
            "border-right-color",
            $render_slug,
            false,
            0,
            '!important'
        );
        $this->set_responsivness(
            'form_fields_border_color_right__hover',
            '%%order_class%% .divi_map-endpoint-content form input:focus',
            "border-right-color",
            $render_slug,
            false,
            0,
            '!important'
        );
        $this->set_responsivness(
            'form_fields_border_width_bottom',
            '%%order_class%% .divi_map-endpoint-content form input',
            "border-bottom-width",
            $render_slug,
            false,
            0,
            '!important'
        );
        $this->set_responsivness(
            'form_fields_border_width_bottom__hover',
            '%%order_class%% .divi_map-endpoint-content form input:focus',
            "border-bottom-width",
            $render_slug,
            false,
            0,
            '!important'
        );
        $this->set_responsivness(
            'form_fields_border_color_bottom',
            '%%order_class%% .divi_map-endpoint-content form input',
            "border-bottom-color",
            $render_slug,
            false,
            0,
            '!important'
        );
        $this->set_responsivness(
            'form_fields_border_color_bottom__hover',
            '%%order_class%% .divi_map-endpoint-content form input:focus',
            "border-bottom-color",
            $render_slug,
            false,
            0,
            '!important'
        );
        $this->set_responsivness(
            'form_fields_border_width_left',
            '%%order_class%% .divi_map-endpoint-content form input',
            "border-left-width",
            $render_slug,
            false,
            0,
            '!important'
        );
        $this->set_responsivness(
            'form_fields_border_width_left__hover',
            '%%order_class%% .divi_map-endpoint-content form input:focus',
            "border-left-width",
            $render_slug,
            false,
            0,
            '!important'
        );
        $this->set_responsivness(
            'form_fields_border_color_left',
            '%%order_class%% .divi_map-endpoint-content form input',
            "border-left-color",
            $render_slug,
            false,
            0,
            '!important'
        );
        $this->set_responsivness(
            'form_fields_border_color_left__hover',
            '%%order_class%% .divi_map-endpoint-content form input:focus',
            "border-left-color",
            $render_slug,
            false,
            0,
            '!important'
        );
    }

    function render($attrs, $content, $render_slug) {
        $this->set_styles($render_slug);
        $shortcode = MAPDL_Classic_My_Account::instance();
        return $shortcode->my_account();
    }

    static function get_account_page_html($args = [], $conditional_tags = array(), $current_page = array()) {
        $endpoint = '';
        if (isset($args['endpoint']) && !empty($args['endpoint'])) {
            $endpoint = $args['endpoint'];
        }
        $shortcode = MAPDL_Classic_My_Account::instance();
        return $shortcode->my_account($endpoint);
    }
}

new ClassicMyaccountModule();
