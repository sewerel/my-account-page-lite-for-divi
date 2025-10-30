<?php

namespace MAPDL\DiviAccountPageLite;

defined('ABSPATH') || exit;

class Icon {

    /**
     * Svgs.
     *
     * @var null
     */
    private static $svgs = null;

    /**
     * Allowed HTML.
     *
     * @var bool[][]
     */
    private static $allowed_svg_html = array(
        'svg'     => array(
            'class'       => true,
            'xmlns'       => true,
            'width'       => true,
            'height'      => true,
            'viewbox'     => true,
            'aria-hidden' => true,
            'role'        => true,
            'focusable'   => true,
        ),
        'path'    => array(
            'fill'      => true,
            'fill-rule' => true,
            'd'         => true,
            'transform' => true,
        ),
        'circle'  => array(
            'cx' => true,
            'cy' => true,
            'r'  => true,
        ),
        'polygon' => array(
            'fill'      => true,
            'fill-rule' => true,
            'points'    => true,
            'transform' => true,
            'focusable' => true,
        ),
    );

    /**
     * Get SVG icon.
     *
     * @param $icon
     * @param bool $echo
     *
     * @return mixed|void
     */
    public static function get_svg_icon($icon, $echo = false) {

        if (is_null(self::$svgs)) {
            ob_start();
            include_once MAPDL_PLUGIN_DIR_LITE . '/assets/svg/icons.json';
            self::$svgs = json_decode(ob_get_clean(), true);
            self::$svgs = apply_filters('mapdl_svg_icons', self::$svgs);
        }

        $svg_icon = isset(self::$svgs[$icon]) ? self::$svgs[$icon] : '';

        if (!$echo) {
            return $svg_icon;
        }

        echo wp_kses($svg_icon, self::$allowed_svg_html);
    }
    public static function get_svg_icons() {

        if (is_null(self::$svgs)) {
            ob_start();
            include_once MAPDL_PLUGIN_DIR_LITE . '/assets/svg/icons.json';
            self::$svgs = json_decode(ob_get_clean(), true);
            self::$svgs = apply_filters('mapdl_svg_icons', self::$svgs);
        }
        return self::$svgs;
    }
}
