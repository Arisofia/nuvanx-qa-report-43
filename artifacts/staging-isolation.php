<?php
/*
Plugin Name: Staging Isolation
Description: Disable emails, HubSpot, tracking pixels, and external hooks in staging.
*/

add_filter('pre_wp_mail', '__return_false');
add_filter('hubspot_tracking_code', '__return_empty_string');
add_filter('hubspot_api_key', '__return_empty_string');

add_action('template_redirect', function() {
    ob_start(function($html) {
        $mock_form = '
        <form class="nvx-hs-lead-form" onsubmit="event.preventDefault(); alert(\'Staging: Formulario aislado.\');">
            <div class="hs-form-field"><label>Nombre</label><input type="text" class="hs-input" required></div>
            <div class="hs-form-field"><label>Correo</label><input type="email" class="hs-input" required></div>
            <div class="hs-submit"><input type="submit" value="Solicitar" class="hs-button primary"></div>
        </form>';

        // Remove HubSpot JS (eu1 or standard)
        $html = preg_replace('/<script[^>]*src=["\']https:\/\/(js|js-eu1)\.(hsforms\.net|hs-scripts\.com)[^>]*><\/script>/i', '', $html);
        
        // Remove tracking pixels
        $html = preg_replace('/<script[^>]*src=["\']https:\/\/connect\.facebook\.net[^>]*><\/script>/i', '', $html);
        $html = preg_replace('/<script[^>]*src=["\']https:\/\/www\.googletagmanager\.com[^>]*><\/script>/i', '', $html);
        
        // Replace native frames
        $html = preg_replace('/<div class="hs-form-frame"[^>]*><\/div>/is', $mock_form, $html);

        return $html;
    });
}, -9999);
