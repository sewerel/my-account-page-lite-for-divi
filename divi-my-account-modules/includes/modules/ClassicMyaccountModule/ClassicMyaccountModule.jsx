// External Dependencies
import React, { Component } from 'react';
import './style.css';


class ClassicMyaccountModule extends Component {

    static slug = 'classic_myaccount';
    static css(props) {
        const classes = {
            order: '%%order_class%%',
            wrap: '.divi_map-MyAccount-wrap',
            nav: '.divi_map-woocommerce-MyAccount-navigation',
            con: '.divi_map-endpoint-content'
        }
        const isTablet = window.ET_Builder.API.State['View_Mode'].isTablet();
        const isPhone = window.ET_Builder.API.State['View_Mode'].isPhone();
        const suffix = isTablet ? '_tablet' : isPhone ? '_phone' : false;
        const css = [];
        if (props.nav_breakpoint) {
            css.push([{
                selector: `@media(max-width:${props.nav_breakpoint}){${classes.order} ${classes.wrap}`,
                declaration: "flex-direction:column;}"
            }]);
            css.push([{
                selector: `@media(max-width:${props.nav_breakpoint}){${classes.order} ${classes.wrap}>div`,
                declaration: "width:100%;}"
            }]);
        }
        if (props.equalize_columns && props.equalize_columns === 'off') {
            css.push([{
                selector: `${classes.order} ${classes.wrap}`,
                declaration: "align-items:flex-start;"
            }]);
        }
        if (props.layout_gap) {
            const layout_gap = props.layout_gap;
            css.push([{
                selector: `${classes.order} ${classes.wrap}`,
                declaration: `gap: ${layout_gap};`
            }]);
        }
        if (suffix && props['layout_gap' + suffix]) {
            const layout_gap_tablet = props['layout_gap' + suffix];
            css.push([{
                selector: `${classes.order} ${classes.wrap}`,
                declaration: `gap: ${layout_gap_tablet};`
            }]);
        }
        //Navigation
        if (props.nav_padding) {
            const nav_padding = props.nav_padding.split('|');
            css.push([{
                selector: `${classes.order} ${classes.nav}`,
                declaration: `padding-top: ${nav_padding[0]};padding-right: ${nav_padding[1]};padding-bottom: ${nav_padding[2]};padding-left: ${nav_padding[3]};`
            }]);
        }
        if (suffix && props['nav_padding' + suffix]) {
            const nav_padding_tablet = props['nav_padding' + suffix].split('|');
            css.push([{
                selector: `${classes.order} ${classes.nav}`,
                declaration: `padding-top: ${nav_padding_tablet[0]};padding-right: ${nav_padding_tablet[1]};padding-bottom: ${nav_padding_tablet[2]};padding-left: ${nav_padding_tablet[3]};`,
            }]);
        }
        if (props.nav_width) {
            css.push([{
                selector: `${classes.order} ${classes.nav}`,
                declaration: `width: ${props.nav_width};`
            }]);
        }
        if (suffix && props['nav_width' + suffix]) {
            css.push([{
                selector: `${classes.order} ${classes.nav}`,
                declaration: `width: ${props['nav_width' + suffix]};`
            }]);
        }

        if (props.nav_background) {
            css.push([{
                selector: `${classes.order} ${classes.nav}`,
                declaration: `background-color:${props.nav_background};`
            }]);
        }

        //Menu item
        if (props.nav_item_padding) {
            const nav_item_padding = props.nav_item_padding.split('|');
            css.push([{
                selector: `${classes.order} ${classes.nav} li a`,
                declaration: `padding-top: ${nav_item_padding[0]};padding-right: ${nav_item_padding[1]};padding-bottom: ${nav_item_padding[2]};padding-left: ${nav_item_padding[3]};`
            }]);
        }
        if (props.nav_item_padding_tablet && isTablet) {
            const nav_item_padding_tablet = props.nav_item_padding_tablet.split('|');
            css.push([{
                selector: `${classes.order} ${classes.nav} li a`,
                declaration: `padding-top: ${nav_item_padding_tablet[0]};padding-right: ${nav_item_padding_tablet[1]};padding-bottom: ${nav_item_padding_tablet[2]};padding-left: ${nav_item_padding_tablet[3]};`,
                divice: 'tablet'
            }]);
        }
        if (props.nav_item_padding_phone && isPhone) {
            const nav_item_padding_phone = props.nav_item_padding_phone.split('|');
            css.push([{
                selector: `${classes.order} ${classes.nav} li a`,
                declaration: `padding-top: ${nav_item_padding_phone[0]};padding-right: ${nav_item_padding_phone[1]};padding-bottom: ${nav_item_padding_phone[2]};padding-left: ${nav_item_padding_phone[3]};`,
                divice: 'phone'
            }]);
        }
        if (props.nav_item_icon_size) {
            const nav_item_icon_size = props.nav_item_icon_size;
            css.push([{
                selector: `${classes.order} ${classes.nav} .divi_map-icon-wrap`,
                declaration: `font-size:${nav_item_icon_size};`
            }]);
        }
        if (props.nav_item_icon_size_tablet && isTablet) {
            const nav_item_icon_size_tablet = props.nav_item_icon_size_tablet;
            css.push([{
                selector: `${classes.order} ${classes.nav} .divi_map-icon-wrap`,
                declaration: `font-size: ${nav_item_icon_size_tablet};`
            }]);
        }
        if (props.nav_item_icon_size_phone && isPhone) {
            const nav_item_icon_size_phone = props.nav_item_icon_size_phone;
            css.push([{
                selector: `${classes.order} ${classes.nav} .divi_map-icon-wrap`,
                declaration: `font-size: ${nav_item_icon_size_phone};`
            }]);
        }
        if (props.nav_item_gap) {
            const nav_item_gap = props.nav_item_gap;
            css.push([{
                selector: `${classes.order} ${classes.nav} ul`,
                declaration: `gap: ${nav_item_gap};`
            }]);
        }
        if (props.nav_item_gap_tablet && isTablet) {
            const nav_item_gap_tablet = props.nav_item_gap_tablet;
            css.push([{
                selector: `${classes.order} ${classes.nav} ul`,
                declaration: `gap: ${nav_item_gap_tablet};`
            }]);
        }
        if (props.nav_item_gap_phone && isPhone) {
            const nav_item_gap_phone = props.nav_item_gap_phone;
            css.push([{
                selector: `${classes.order} ${classes.nav} ul`,
                declaration: `gap: ${nav_item_gap_phone};`
            }]);
        }
        if (props.nav_item_background) {
            css.push([{
                selector: `${classes.order} ${classes.nav} li a`,
                declaration: `background-color:${props.nav_item_background};`
            }]);
        }
        if (props.nav_item_background__hover) {
            css.push([{
                selector: `${classes.order} ${classes.nav} li a:hover`,
                declaration: `background-color:${props.nav_item_background__hover};`
            }]);
        }

        //nav item active
        if (props.nav_item_active_background) {
            css.push([{
                selector: `${classes.order} ${classes.nav} li.tab_selected a`,
                declaration: `background-color:${props.nav_item_active_background};`
            }]);
        }

        //Endpoint
        if (props.endpoint_content_padding) {
            const endpoint_content_padding = props.endpoint_content_padding.split('|');
            css.push([{
                selector: `${classes.order} ${classes.con}`,
                declaration: `padding-top: ${endpoint_content_padding[0]};padding-right: ${endpoint_content_padding[1]};padding-bottom: ${endpoint_content_padding[2]};padding-left: ${endpoint_content_padding[3]};`
            }]);
        }

        if (props.endpoint_content_padding_tablet && isTablet) {
            const endpoint_content_padding_tablet = props.endpoint_content_padding_tablet.split('|');
            css.push([{
                selector: `${classes.order} ${classes.con}`,
                declaration: `padding-top: ${endpoint_content_padding_tablet[0]};padding-right: ${endpoint_content_padding_tablet[1]};padding-bottom: ${endpoint_content_padding_tablet[2]};padding-left: ${endpoint_content_padding_tablet[3]};`,
                divice: 'tablet'
            }]);
        }
        if (props.endpoint_content_padding_phone && isPhone) {
            const endpoint_content_padding_phone = props.endpoint_content_padding_phone.split('|');
            css.push([{
                selector: `${classes.order} ${classes.con}`,
                declaration: `padding-top: ${endpoint_content_padding_phone[0]};padding-right: ${endpoint_content_padding_phone[1]};padding-bottom: ${endpoint_content_padding_phone[2]};padding-left: ${endpoint_content_padding_phone[3]};`,
                divice: 'phone'
            }]);
        }
        if (props.endpoint_background) {
            css.push([{
                selector: `${classes.order} ${classes.con}`,
                declaration: `background-color:${props.endpoint_background};`
            }]);
        }
        //tables
        if (props.table_border_radius) {
            const table_border_radius = props.table_border_radius.split('|');
            css.push([{
                selector: `${classes.order} .woocommerce ${classes.con} table`,
                declaration: `
                border-top-left-radius:${table_border_radius[1]};
                border-top-right-radius:${table_border_radius[2]};
                border-bottom-right-radius:${table_border_radius[3]};
                border-bottom-left-radius:${table_border_radius[4]};
                `
            }]);
        }
        if (suffix && props['table_border_radius' + suffix]) {
            const table_border_radius_mobile = props['table_border_radius' + suffix].split('|');
            css.push([{
                selector: `${classes.order} .woocommerce ${classes.con} table`,
                declaration: `
                border-top-left-radius:${table_border_radius_mobile[1]};
                border-top-right-radius:${table_border_radius_mobile[2]};
                border-bottom-right-radius:${table_border_radius_mobile[3]};
                border-bottom-left-radius:${table_border_radius_mobile[4]};
                `
            }]);
        }
        if (props.table_border_width) {
            css.push([{
                selector: `${classes.order} .woocommerce ${classes.con} table`,
                declaration: `border-width:${props.table_border_width};`
            }]);
        }
        if (props.table_border_color) {
            css.push([{
                selector: `${classes.order} .woocommerce ${classes.con} table`,
                declaration: `border-color:${props.table_border_color};`
            }]);
        }
        if (props.table_inner_border_width) {
            css.push([{
                selector: `${classes.order} .woocommerce ${classes.con} table td,${classes.order} .woocommerce ${classes.con} tbody th`,
                declaration: `border-top-width:${props.table_inner_border_width};`
            }]);
        }
        if (props.table_inner_border_color) {
            css.push([{
                selector: `${classes.order} .woocommerce ${classes.con} table td,${classes.order} .woocommerce ${classes.con} tbody th`,
                declaration: `border-top-color:${props.table_inner_border_color};`
            }]);
        }
        if (props.table_head_padding) {
            const table_head_padding = props.table_head_padding.split('|');
            css.push([{
                selector: `${classes.order} .woocommerce ${classes.con} table th`,
                declaration: `padding-top: ${table_head_padding[0]};padding-right: ${table_head_padding[1]};padding-bottom: ${table_head_padding[2]};padding-left: ${table_head_padding[3]};`
            }]);
        }
        if (suffix && props['table_head_padding' + suffix]) {
            const table_head_padding_mobile = props['table_head_padding' + suffix].split('|');
            css.push([{
                selector: `${classes.order} .woocommerce ${classes.con} table th`,
                declaration: `padding-top: ${table_head_padding_mobile[0]};padding-right: ${table_head_padding_mobile[1]};padding-bottom: ${table_head_padding_mobile[2]};padding-left: ${table_head_padding_mobile[3]};`
            }]);
        }
        if (props.table_head_background) {
            css.push([{
                selector: `${classes.order} .woocommerce ${classes.con} table thead`,
                declaration: `background-color:${props.table_head_background};`
            }]);
        }
        if (props.table_data_padding) {
            const table_data_padding = props.table_data_padding.split('|');
            css.push([{
                selector: `${classes.order} .woocommerce ${classes.con} table td,${classes.order} .woocommerce ${classes.con} tbody th`,
                declaration: `padding-top: ${table_data_padding[0]};padding-right: ${table_data_padding[1]};padding-bottom: ${table_data_padding[2]};padding-left: ${table_data_padding[3]};`
            }]);
        }
        if (suffix && props['table_data_padding' + suffix]) {
            const table_data_padding_mobile = props['table_data_padding' + suffix].split('|');
            css.push([{
                selector: `${classes.order} .woocommerce ${classes.con} table td,${classes.order} .woocommerce ${classes.con} tbody th`,
                declaration: `padding-top: ${table_data_padding_mobile[0]};padding-right: ${table_data_padding_mobile[1]};padding-bottom: ${table_data_padding_mobile[2]};padding-left: ${table_data_padding_mobile[3]};`
            }]);
        }
        if (props.table_data_background) {
            css.push([{
                selector: `${classes.order} .woocommerce ${classes.con} table tbody`,
                declaration: `background-color:${props.table_data_background};`
            }]);
        }
        if (props.table_odd_background) {
            css.push([{
                selector: `${classes.order} .woocommerce ${classes.con} table tbody tr:nth-child(odd)`,
                declaration: `background-color:${props.table_odd_background};`
            }]);
        }
        if (props.table_even_background) {
            css.push([{
                selector: `${classes.order} .woocommerce ${classes.con} table tbody tr:nth-child(even)`,
                declaration: `background-color:${props.table_even_background};`
            }]);
        }
        //Notifications
        if (props.notice_background) {
            css.push([{
                selector: `${classes.order} .woocommerce .woocommerce-info,${classes.order} .woocommerce .woocommerce-error,${classes.order} .woocommerce .woocommerce-message`,
                declaration: `background-color:${props.notice_background}!important;`
            }]);
        }
        if (props.notice_padding) {
            const notice_padding = props.notice_padding.split('|');
            css.push([{
                selector: `${classes.order} .woocommerce .woocommerce-info,${classes.order} .woocommerce .woocommerce-error,${classes.order} .woocommerce .woocommerce-message`,
                declaration: `padding-top: ${notice_padding[0]}!important;padding-right: ${notice_padding[1]}!important;padding-bottom: ${notice_padding[2]}!important;padding-left: ${notice_padding[3]}!important;`
            }]);
        }
        if (suffix && props['notice_padding' + suffix]) {
            const notice_padding_mobile = props['notice_padding' + suffix].split('|');
            css.push([{
                selector: `${classes.order} .woocommerce .woocommerce-info,${classes.order} .woocommerce .woocommerce-error,${classes.order} .woocommerce .woocommerce-message`,
                declaration: `padding-top: ${notice_padding_mobile[0]}!important;padding-right: ${notice_padding_mobile[1]}!important;padding-bottom: ${notice_padding_mobile[2]}!important;padding-left: ${notice_padding_mobile[3]}!important;`
            }]);
        }
        //Table button padding
        if (props.table_button_custom_padding) {
            const table_button_custom_padding = props.table_button_custom_padding.split('|');
            css.push([{
                selector: `${classes.order} .woocommerce ${classes.con} table .button`,
                declaration: `padding-top: ${table_button_custom_padding[0]}!important;padding-right: ${table_button_custom_padding[1]}!important;padding-bottom: ${table_button_custom_padding[2]}!important;padding-left: ${table_button_custom_padding[3]}!important;`
            }]);
        }
        if (props.table_button_custom_padding__hover) {
            const table_button_custom_padding__hover = props.table_button_custom_padding__hover.split('|');
            css.push([{
                selector: `${classes.order} .woocommerce ${classes.con} table .button:hover`,
                declaration: `padding-top: ${table_button_custom_padding__hover[0]}!important;padding-right: ${table_button_custom_padding__hover[1]}!important;padding-bottom: ${table_button_custom_padding__hover[2]}!important;padding-left: ${table_button_custom_padding__hover[3]}!important;`
            }]);
        }
        if (suffix && props['table_button_custom_padding' + suffix]) {
            const table_button_custom_padding_mobile = props['table_button_custom_padding' + suffix].split('|');
            css.push([{
                selector: `${classes.order} .woocommerce ${classes.con} table .button`,
                declaration: `padding-top: ${table_button_custom_padding_mobile[0]}!important;padding-right: ${table_button_custom_padding_mobile[1]}!important;padding-bottom: ${table_button_custom_padding_mobile[2]}!important;padding-left: ${table_button_custom_padding_mobile[3]}!important;`
            }]);
        }
        // //Notice button padding
        if (props.notice_button_custom_padding) {
            const notice_button_custom_padding = props.notice_button_custom_padding.split('|');
            css.push([{
                selector: `${classes.order} .woocommerce ${classes.con}>div[class^='woocommerce-'] .button`,
                declaration: `padding-top: ${notice_button_custom_padding[0]}!important;padding-right: ${notice_button_custom_padding[1]}!important;padding-bottom: ${notice_button_custom_padding[2]}!important;padding-left: ${notice_button_custom_padding[3]}!important;`
            }]);
        }
        if (props.notice_button_custom_padding__hover) {
            const notice_button_custom_padding__hover = props.notice_button_custom_padding__hover.split('|');
            css.push([{
                selector: `${classes.order} .woocommerce ${classes.con}>div[class^='woocommerce-'] .button:hover`,
                declaration: `padding-top: ${notice_button_custom_padding__hover[0]}!important;padding-right: ${notice_button_custom_padding__hover[1]}!important;padding-bottom: ${notice_button_custom_padding__hover[2]}!important;padding-left: ${notice_button_custom_padding__hover[3]}!important;`
            }]);
        }
        if (suffix && props['notice_button_custom_padding' + suffix]) {
            const notice_button_custom_padding_mobile = props['notice_button_custom_padding' + suffix].split('|');
            css.push([{
                selector: `${classes.order} .woocommerce ${classes.con}>div[class^='woocommerce-'] .button`,
                declaration: `padding-top: ${notice_button_custom_padding_mobile[0]}!important;padding-right: ${notice_button_custom_padding_mobile[1]}!important;padding-bottom: ${notice_button_custom_padding_mobile[2]}!important;padding-left: ${notice_button_custom_padding_mobile[3]}!important;`
            }]);
        }
        //Form button padding
        if (props.form_button_custom_padding) {
            const form_button_custom_padding = props.form_button_custom_padding.split('|');
            css.push([{
                selector: `${classes.order} .woocommerce ${classes.con} form .button`,
                declaration: `padding-top: ${form_button_custom_padding[0]}!important;padding-right: ${form_button_custom_padding[1]}!important;padding-bottom: ${form_button_custom_padding[2]}!important;padding-left: ${form_button_custom_padding[3]}!important;`
            }]);
        }
        if (props.form_button_custom_padding__hover) {
            const form_button_custom_padding__hover = props.form_button_custom_padding__hover.split('|');
            css.push([{
                selector: `${classes.order} .woocommerce ${classes.con} form .button:hover`,
                declaration: `padding-top: ${form_button_custom_padding__hover[0]}!important;padding-right: ${form_button_custom_padding__hover[1]}!important;padding-bottom: ${form_button_custom_padding__hover[2]}!important;padding-left: ${form_button_custom_padding__hover[3]}!important;`
            }]);
        }
        if (suffix && props['form_button_custom_padding' + suffix]) {
            const form_button_custom_padding_mobile = props['form_button_custom_padding' + suffix].split('|');
            css.push([{
                selector: `${classes.order} .woocommerce ${classes.con} form input`,
                declaration: `padding-top: ${form_button_custom_padding_mobile[0]}!important;padding-right: ${form_button_custom_padding_mobile[1]}!important;padding-bottom: ${form_button_custom_padding_mobile[2]}!important;padding-left: ${form_button_custom_padding_mobile[3]}!important;`
            }]);
        }
        //Form fields padding
        if (props.form_fields_custom_padding) {
            const form_fields_custom_padding = props.form_fields_custom_padding.split('|');
            css.push([{
                selector: `${classes.order} .woocommerce ${classes.con} form input`,
                declaration: `padding-top: ${form_fields_custom_padding[0]}!important;padding-right: ${form_fields_custom_padding[1]}!important;padding-bottom: ${form_fields_custom_padding[2]}!important;padding-left: ${form_fields_custom_padding[3]}!important;`
            }]);
        }
        if (props.form_fields_custom_padding__hover) {
            const form_fields_custom_padding__hover = props.form_fields_custom_padding__hover.split('|');
            css.push([{
                selector: `${classes.order} .woocommerce ${classes.con} form input:focus`,
                declaration: `padding-top: ${form_fields_custom_padding__hover[0]}!important;padding-right: ${form_fields_custom_padding__hover[1]}!important;padding-bottom: ${form_fields_custom_padding__hover[2]}!important;padding-left: ${form_fields_custom_padding__hover[3]}!important;`
            }]);
        }
        if (suffix && props['form_fields_custom_padding' + suffix]) {
            const form_fields_custom_padding_mobile = props['form_fields_custom_padding' + suffix].split('|');
            css.push([{
                selector: `${classes.order} .woocommerce ${classes.con} form input`,
                declaration: `padding-top: ${form_fields_custom_padding_mobile[0]}!important;padding-right: ${form_fields_custom_padding_mobile[1]}!important;padding-bottom: ${form_fields_custom_padding_mobile[2]}!important;padding-left: ${form_fields_custom_padding_mobile[3]}!important;`
            }]);
        }
        //Radius
        if (props.form_fields_border_radius) {
            const form_fields_border_radius = props.form_fields_border_radius.split('|');
            css.push([{
                selector: `${classes.order} ${classes.con} form input`,
                declaration: `
        border-top-left-radius:${form_fields_border_radius[1]}!important;
        border-top-right-radius:${form_fields_border_radius[2]}!important;
        border-bottom-right-radius:${form_fields_border_radius[3]}!important;
        border-bottom-left-radius:${form_fields_border_radius[4]}!important;
        `
            }]);
        }
        if (props.form_fields_border_radius__hover) {
            const form_fields_border_radius = props.form_fields_border_radius.split('|');
            css.push([{
                selector: `${classes.order} ${classes.con} form input:focus`,
                declaration: `
        border-top-left-radius:${form_fields_border_radius[1]}!important;
        border-top-right-radius:${form_fields_border_radius[2]}!important;
        border-bottom-right-radius:${form_fields_border_radius[3]}!important;
        border-bottom-left-radius:${form_fields_border_radius[4]}!important;
        `
            }]);
        }
        if (suffix && props['form_fields_border_radius' + suffix]) {
            const form_fields_border_radius_tablet = props['form_fields_border_radius' + suffix].split('|');
            css.push([{
                selector: `${classes.order} ${classes.con} form input`,
                declaration: `
        border-top-left-radius:${form_fields_border_radius_tablet[1]}!important;
        border-top-right-radius:${form_fields_border_radius_tablet[2]}!important;
        border-bottom-left-radius:${form_fields_border_radius_tablet[3]}!important;
        border-bottom-left-radius:${form_fields_border_radius_tablet[4]}!important;
        `
            }]);
        }
        //Border All
        if (props.form_fields_border_width) {
            css.push([{
                selector: `${classes.order} ${classes.con} form input`,
                declaration: `border-width:${props.form_fields_border_width}!important;`
            }])
        }
        if (props.form_fields_border_color) {
            css.push([{
                selector: `${classes.order} ${classes.con} form input`,
                declaration: `border-color:${props.form_fields_border_color}!important;`
            }])
        }
        if (props.form_fields_border_width__hover) {
            css.push([{
                selector: `${classes.order} ${classes.con} form input:focus`,
                declaration: `border-width:${props.form_fields_border_width__hover}!important;`
            }])
        }
        if (props.form_fields_border_color__hover) {
            css.push([{
                selector: `${classes.order} ${classes.con} form input:focus`,
                declaration: `border-color:${props.form_fields_border_color__hover}!important;`
            }])
        }
        //Border Top
        if (props.form_fields_border_width_top) {
            css.push([{
                selector: `${classes.order} ${classes.con} form input`,
                declaration: `border-top-width:${props.form_fields_border_width_top}!important;`
            }])
        }
        if (props.form_fields_border_color_top) {
            css.push([{
                selector: `${classes.order} ${classes.con} form input`,
                declaration: `border-top-color:${props.form_fields_border_color_top}!important;`
            }])
        }
        if (props.form_fields_border_width_top__hover) {
            css.push([{
                selector: `${classes.order} ${classes.con} form input:focus`,
                declaration: `border-top-width:${props.form_fields_border_width_top__hover}!important;`
            }])
        }
        if (props.form_fields_border_color_top__hover) {
            css.push([{
                selector: `${classes.order} ${classes.con} form input:focus`,
                declaration: `border-top-color:${props.form_fields_border_color_top__hover}!important;`
            }])
        }
        //Border Right
        if (props.form_fields_border_width_right) {
            css.push([{
                selector: `${classes.order} ${classes.con} form input`,
                declaration: `border-right-width:${props.form_fields_border_width_right}!important;`
            }])
        }
        if (props.form_fields_border_color_right) {
            css.push([{
                selector: `${classes.order} ${classes.con} form input`,
                declaration: `border-right-color:${props.form_fields_border_color_right}!important;`
            }])
        }
        if (props.form_fields_border_width_right__hover) {
            css.push([{
                selector: `${classes.order} ${classes.con} form input:focus`,
                declaration: `border-right-width:${props.form_fields_border_width_right__hover}!important;`
            }])
        }
        if (props.form_fields_border_color_right__hover) {
            css.push([{
                selector: `${classes.order} ${classes.con} form input:focus`,
                declaration: `border-right-color:${props.form_fields_border_color_right__hover}!important;`
            }])
        }
        //Border Bottom
        if (props.form_fields_border_width_bottom) {
            css.push([{
                selector: `${classes.order} ${classes.con} form input`,
                declaration: `border-bottom-width:${props.form_fields_border_width_bottom}!important;`
            }])
        }
        if (props.form_fields_border_color_bottom) {
            css.push([{
                selector: `${classes.order} ${classes.con} form input`,
                declaration: `border-bottom-color:${props.form_fields_border_color_bottom}!important;`
            }])
        }
        if (props.form_fields_border_width_bottom__hover) {
            css.push([{
                selector: `${classes.order} ${classes.con} form input:focus`,
                declaration: `border-bottom-width:${props.form_fields_border_width_bottom__hover}!important;`
            }])
        }
        if (props.form_fields_border_color_bottom__hover) {
            css.push([{
                selector: `${classes.order} ${classes.con} form input:focus`,
                declaration: `border-bottom-color:${props.form_fields_border_color_bottom__hover}!important;`
            }])
        }
        //Border Left
        if (props.form_fields_border_width_left) {
            css.push([{
                selector: `${classes.order} ${classes.con} form input`,
                declaration: `border-left-width:${props.form_fields_border_width_left}!important;`
            }])
        }
        if (props.form_fields_border_color_left) {
            css.push([{
                selector: `${classes.order} ${classes.con} form input`,
                declaration: `border-left-color:${props.form_fields_border_color_left}!important;`
            }])
        }
        if (props.form_fields_border_width_left__hover) {
            css.push([{
                selector: `${classes.order} ${classes.con} form input:focus`,
                declaration: `border-left-width:${props.form_fields_border_width_left__hover}!important;`
            }])
        }
        if (props.form_fields_border_color_left__hover) {
            css.push([{
                selector: `${classes.order} ${classes.con} form input:focus`,
                declaration: `border-left-color:${props.form_fields_border_color_left__hover}!important;`
            }])
        }
        if (props.form_fields_background) {
            css.push([{
                selector: `${classes.order} ${classes.con} form input`,
                declaration: `background-color:${props.form_fields_background}!important;`
            }]);
        }
        if (props.form_fields_background__hover) {
            css.push([{
                selector: `${classes.order} ${classes.con} form input:focus`,
                declaration: `background-color:${props.form_fields_background__hover}!important;`
            }]);
        }


        return css;
    }



    /**
     * Render component output
     *
     * @return {string|React.Component|React.component[]}
     */
    render() {

        return (
            <div dangerouslySetInnerHTML={{ __html: this.props.__html }} />
        );
    }
}

export default ClassicMyaccountModule;
