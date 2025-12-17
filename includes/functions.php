<?php
add_action('mapdl_before_endpoint_content', 'mapdl_display_before_content', 10, 1);
add_action('mapdl_after_endpoint_content', 'mapdl_display_after_content', 10, 1);
add_filter('mapdl_before_endpoint_slug', 'mapdl_before_endpoint_slug');
add_filter('mapdl_connected_sub_endpoint', 'mapdl_connected_sub_endpoint');
if (!function_exists('mapdl_display_before_content')) {
    function mapdl_display_before_content($slug) {

        echo '<div class="divi_map-endpoint-content">';
        woocommerce_output_all_notices();
    }
}
if (!function_exists('mapdl_display_after_content')) {
    function mapdl_display_after_content($slug) {

        echo '</div><!--divi_map-endpoint-content-->';
    }
}
if (!function_exists('mapdl_connected_sub_endpoint')) {
    function mapdl_connected_sub_endpoint($slug) {
        if ($slug === 'orders') {
            return 'view-order';
        } elseif ($slug === 'subscriptions') {
            return 'view-subscription';
        }
        return $slug;
    }
}
if (!function_exists('mapdl_get_endpoints_array')) {
    function mapdl_get_endpoints_array($endpoints = array()) {
        if (empty($endpoints)) {
            $endpoints = MAPDL_LITE()->get_settings()->get_endpoints();
        }
        $endpoints_array = array();
        foreach ($endpoints as $slug => $endpoint) {
            if ($slug === 'customer-logout') {
                continue;
            }
            $endpoints_array[] = $slug;
            $maybe_subpoint = apply_filters('mapdl_connected_sub_endpoint', $slug);
            if ($slug !== $maybe_subpoint) {
                if (is_array($maybe_subpoint)) {
                    foreach ($maybe_subpoint as $name) {
                        $endpoints_array[] = $name;
                    }
                } else {

                    $endpoints_array[] = $maybe_subpoint;
                }
            }
        }

        return $endpoints_array;
    }
}

if (!function_exists('mapdl_before_endpoint_slug')) {
    function mapdl_before_endpoint_slug($slug) {
        if ($slug === 'view-order') {
            return 'orders';
        } elseif ($slug === 'view-subscription') {
            return 'subscriptions';
        }
        return $slug;
    }
}
if (!function_exists('mapdl_get_user_roles')) {

    function mapdl_get_user_roles($user = null) {
        if (!is_user_logged_in()) {
            return array();
        }

        $user = null === $user ? wp_get_current_user() : $user;

        if (is_int($user)) {
            $user = get_user_by('id', $user);
        }

        if (!is_a($user, 'WP_User')) {
            return array();
        }

        return (array) $user->roles;
    }
}
if (!function_exists('mapdl_get_endpoints_flat')) {
    function mapdl_get_endpoints_flat($endpoints = array()) {
        if (empty($endpoints)) {
            $endpoints = MAPDL_LITE()->get_settings()->get_endpoints();
        }
        $flat_endpoints = array();
        foreach ($endpoints as $slug => $endpoint) {
            $flat_endpoints[$slug] = $endpoint;
        }

        return $flat_endpoints;
    }
}
if (!function_exists('mapdl_get_endpoints_for_select')) {
    function mapdl_get_endpoints_for_select($endpoints = array()) {
        if (empty($endpoints)) {
            $endpoints = MAPDL_LITE()->get_settings()->get_endpoints();
        }
        $for_select_endpoints = array();
        foreach ($endpoints as $slug => $endpoint) {
            if ($slug === 'customer-logout') {
                continue;
            }
            $for_select_endpoints[$slug] = $endpoint['label'];
        }

        return $for_select_endpoints;
    }
}

if (!function_exists('mapdl_get_default_endpoint')) {
    /**
     * Get the default endpoint from settings.
     *
     * @since 0.1.0
     * @return string
     */
    function mapdl_get_default_endpoint() {
        $settings = MAPDL_LITE()->get_settings()->get_settings();

        return apply_filters('mapdl_default_endpoint', $settings['default_endpoint']);
    }
}

if (!function_exists('mapdl_get_default_endpoint_options')) {

    function mapdl_get_default_endpoint_options($endpoint = '') {
        $options = array(
            'type'              => 'endpoint',
            'enable'            => true,
            'label'             => $endpoint,
            'slug'              => '',
            'icon'              => '',
            'user_role'         => array(),
            'content_enable'  => true,
            'before'   => array(
                'title' => '',
                'id'    => ''
            ),
            'after' => array(
                'title' => '',
                'id'    => ''
            ),
        );

        return apply_filters('mapdl_get_default_endpoint_options', $options, $endpoint);
    }
}
if (!function_exists('mapdl_get_default_link_options')) {
    /**
     * Default link options.
     *
     * @since 0.1.0
     *
     * @param string $link
     * @return array
     */
    function mapdl_get_default_link_options($link = '') {
        $options = array(
            'type'      => 'link',
            'enable'    => true,
            'url'       => '',
            'label'     => $link,
            'icon'      => '',
            'user_role' => array(),
            'new_tab'   => false,
        );

        return apply_filters('mapdl_get_default_link_options', $options, $link);
    }
}

if (!function_exists('mapdl_get_endpoints_by_type')) {

    function mapdl_get_endpoints_by_type($type) {
        $endpoints = mapdl_get_endpoints_flat();

        $endpoints = array_filter(
            $endpoints,
            function ($endpoint) use ($type) {
                return $type === $endpoint['type'];
            }
        );

        return apply_filters('mapdl_get_endpoints_by_type', $endpoints, $type);
    }
}

if (!function_exists('mapdl_get_endpoint')) {

    function mapdl_get_endpoint($slug) {
        $endpoints = mapdl_get_endpoints_flat();
        $endpoint  = isset($endpoints[$slug]) ? $endpoints[$slug] : false;

        return apply_filters('mapdl_get_endpoint', $endpoint, $slug);
    }
}

if (!function_exists('mapdl_get_link_url')) {

    function mapdl_get_link_url($endpoint) {
        $endpoint = mapdl_get_endpoint($endpoint);
        $url      = isset($endpoint['url']) ? $endpoint['url'] : '';

        return apply_filters('mapdl_get_link_url', $url, $endpoint);
    }
}

function mapdl_display_account_content($slug) {
    $endpoint = mapdl_get_endpoint($slug);

    // Bail early if endpoint doesn't exist.
    if (!$endpoint) {
        return false;
    }
    return true;
}

function mapdl_display_dashboard() {
    $endpoints = mapdl_get_endpoints_flat();
    $endpoint = $endpoints['dashboard'];

    if (!$endpoint['enable']) {
        return '';
    }
    if ($endpoint['content_enable']) {
        wc_get_template(
            'myaccount/dashboard.php',
            array(
                'current_user' => get_user_by('id', get_current_user_id()),
            )
        );
    }
}

function mapdl_get_account_menu_items($endpoints = array()) {

    if (empty($endpoints)) {
        $endpoints = MAPDL_LITE()->get_settings()->get_endpoints();
    }

    if (
        function_exists('wc_memberships_get_user_memberships') &&
        empty(wc_memberships_get_user_memberships()) &&
        array_key_exists('members-area', $endpoints)
    ) {
        unset($endpoints['members-area']);
    }

    return array_map(
        function ($endpoint) {
            return $endpoint['label'];
        },
        $endpoints
    );
}
