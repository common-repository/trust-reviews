<?php

namespace WP_Trust_Reviews_Plugin\Includes;

class Plugin_Settings {

    public function __construct(Debug_Info $debug_info) {
        $this->debug_info = $debug_info;
    }

    public function register() {
        add_action('trp_admin_page_trp-settings', array($this, 'init'));
        add_action('trp_admin_page_trp-settings', array($this, 'render'));
    }

    public function init() {

    }

    public function render() {

        $tab = isset($_GET['trp_tab']) && strlen($_GET['trp_tab']) > 0 ? sanitize_text_field(wp_unslash($_GET['trp_tab'])) : 'active';

        $trp_enabled            = get_option('trp_active') == '1';
        $trp_demand_assets      = get_option('trp_demand_assets');
        $trp_minified_assets    = get_option('trp_minified_assets');

        $trp_google_api_key     = get_option('trp_google_api_key');
        $trp_google_places_api  = get_option('trp_google_places_api');
        $trp_yelp_api_key       = get_option('trp_yelp_api_key');

        $trp_latest_version     = get_option('trp_latest_version');

        $milliseconds           = round(microtime(true) * 1000);
        ?>

        <div class="trp-page-title">
            Settings
        </div>

        <?php do_action('trp_admin_notices'); ?>

        <div class="trp-settings-workspace">

            <div data-nav-tabs="">
                <div class="nav-tab-wrapper">
                    <a href="#trp-general"  class="nav-tab<?php if ($tab == 'active')   { ?> nav-tab-active<?php } ?>">General</a>
                    <a href="#trp-google"   class="nav-tab<?php if ($tab == 'google')   { ?> nav-tab-active<?php } ?>">Google</a>
                    <a href="#trp-facebook" class="nav-tab<?php if ($tab == 'facebook') { ?> nav-tab-active<?php } ?>">Facebook</a>
                    <a href="#trp-yelp"     class="nav-tab<?php if ($tab == 'yelp')     { ?> nav-tab-active<?php } ?>">Yelp</a>
                    <a href="#trp-advance"  class="nav-tab<?php if ($tab == 'advance')  { ?> nav-tab-active<?php } ?>">Advance</a>
                </div>

                <div id="trp-general" class="tab-content" style="display:<?php echo $tab == 'active' ? 'block' : 'none'?>;">
                    <h3>General Settings</h3>
                    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php?action=trp_settings_save&trp_tab=active&active=' . (string)((int)($trp_enabled != true)))); ?>">
                        <div class="trp-field">
                            <div class="trp-field-label">
                                <label>Trust Reviews is currently <b><?php echo $trp_enabled ? 'enabled' : 'disabled' ?></b></label>
                            </div>
                            <div class="wp-review-field-option">
                                <?php wp_nonce_field('trp-wpnonce_active', 'trp-form_nonce_active'); ?>
                                <input type="submit" name="active" class="button" value="<?php echo $trp_enabled ? 'Disable' : 'Enable'; ?>" />
                            </div>
                        </div>
                        <div class="trp-field">
                            <div class="trp-field-label">
                                <label>Load assets on demand</label>
                            </div>
                            <div class="wp-review-field-option">
                                <label>
                                    <input type="hidden" name="trp_demand_assets" value="false">
                                    <input type="checkbox" id="trp_demand_assets" name="trp_demand_assets" value="true" <?php checked('true', $trp_demand_assets); ?>>
                                    Load static assets (JavaScripts/CSS) only on pages where reviews are showing
                                </label>
                            </div>
                        </div>
                        <div class="trp-field">
                            <div class="trp-field-label">
                                <label>Minify and assemble assets</label>
                            </div>
                            <div class="wp-review-field-option">
                                <label>
                                    <input type="hidden" name="trp_minified_assets" value="false">
                                    <input type="checkbox" id="trp_minified_assets" name="trp_minified_assets" value="true" <?php checked('true', $trp_minified_assets); ?>>
                                    Minify and assemble static assets (JavaScripts/CSS) to single style and script files
                                </label>
                                <div style="padding-top:15px">
                                    <input type="submit" value="Save" name="save" class="button" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="trp-google" class="tab-content" style="display:<?php echo $tab == 'google' ? 'block' : 'none'?>;">
                    <h3>Google</h3>
                    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php?action=trp_settings_save&trp_tab=google')); ?>">
                        <?php wp_nonce_field('trp-wpnonce_save', 'trp-form_nonce_save'); ?>
                        <div class="trp-field">
                            <div class="trp-field-label">
                                <label>Google Places API key</label>
                            </div>
                            <div class="wp-review-field-option">
                                <input type="text" id="trp_google_api_key" name="trp_google_api_key" class="regular-text" value="<?php echo esc_attr($trp_google_api_key); ?>">
                                <p>If you have any questions with that, please see a full guide about connecting your Google place <a href="<?php echo admin_url('admin.php?page=trp-support&trp_tab=google'); ?>">here</a>.</p>
                                <div style="padding-top:15px">
                                    <input type="submit" value="Save" name="save" class="button" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="trp-facebook" class="tab-content" style="display:<?php echo $tab == 'facebook' ? 'block' : 'none'?>;">
                    <h3>Facebook</h3>
                    <p>There are no specific settings for the Facebook platform.</p>
                    <p>If you are looking how to connect the Facebook reviews, you need to <a href="<?php echo admin_url('admin.php'); ?>?page=trp-builder">create reviews feed</a> and use 'Facebook Reviews' section.</p>
                </div>

                <div id="trp-yelp" class="tab-content" style="display:<?php echo $tab == 'yelp' ? 'block' : 'none'?>;">
                    <h3>Yelp</h3>
                    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php?action=trp_settings_save&trp_tab=yelp')); ?>">
                        <?php wp_nonce_field('trp-wpnonce_save', 'trp-form_nonce_save'); ?>
                        <div class="trp-field">
                            <div class="trp-field-label">
                                <label>Yelp API key</label>
                            </div>
                            <div class="wp-review-field-option">
                                <input type="text" id="trp_yelp_api_key" name="trp_yelp_api_key" class="regular-text" value="<?php echo esc_attr($trp_yelp_api_key); ?>">
                                <p>If you have any questions with that, please see a full guide about connecting your Yelp business <a href="<?php echo admin_url('admin.php?page=trp-support&trp_tab=yelp'); ?>">here</a>.</p>
                                <div style="padding-top:15px">
                                    <input type="submit" value="Save" name="save" class="button" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="trp-advance" class="tab-content" style="display:<?php echo $tab == 'advance' ? 'block' : 'none'?>;">
                    <h3>Advance</h3>
                    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php?action=trp_settings_save&trp_tab=advance')); ?>">
                        <div class="trp-field">
                            <div class="trp-field-label">
                                <label>Re-create the database tables of the plugin (service option)</label>
                            </div>
                            <div class="wp-review-field-option">
                                <?php wp_nonce_field('trp-wpnonce_create_db', 'trp-form_nonce_create_db'); ?>
                                <input type="submit" value="Re-create Database" name="create_db" onclick="return confirm('Are you sure you want to re-create database tables?')" class="button" />
                            </div>
                        </div>
                        <div class="trp-field">
                            <div class="trp-field-label">
                                <label><b>Please be careful</b>: this removes all settings, reviews, feeds and install the plugin from scratch</label>
                            </div>
                            <div class="wp-review-field-option">
                                <?php wp_nonce_field('trp-wpnonce_create_db', 'trp-form_nonce_create_db'); ?>
                                <input type="submit" value="Install from scratch" name="install" onclick="return confirm('It will delete all current feeds, are you sure you want to install from scratch the plugin?')" class="button" />
                                <p><label><input type="checkbox" id="install_multisite" name="install_multisite"> For all sites (WP Multisite)</label></p>
                            </div>
                        </div>
                        <div class="trp-field">
                            <div class="trp-field-label">
                                <label><b>Please be careful</b>: this removes all plugin-specific settings, reviews and feeds</label>
                            </div>
                            <div class="wp-review-field-option">
                                <?php wp_nonce_field('trp-wpnonce_reset_all', 'trp-form_nonce_reset_all'); ?>
                                <input type="submit" value="Delete All Data" name="reset_all" onclick="return confirm('Are you sure you want to reset all plugin data including feeds?')" class="button" />
                                <p><label><input type="checkbox" id="reset_all_multisite" name="reset_all_multisite"> For all sites (WP Multisite)</label></p>
                            </div>
                        </div>
                        <div id="debug_info" class="trp-field">
                            <div class="trp-field-label">
                                <label>Debug information</label>
                            </div>
                            <div class="wp-review-field-option">
                                <input type="button" value="Copy Debug Information" name="reset_all" onclick="window.trp_debug_info.select();document.execCommand('copy');window.trp_debug_msg.innerHTML='Debug Information copied, please paste it to your email to support';" class="button" />
                                <textarea id="trp_debug_info" style="display:block;width:30em;height:100px;margin-top:10px" onclick="window.trp_debug_info.select();document.execCommand('copy');window.trp_debug_msg.innerHTML='Debug Information copied, please paste it to your email to support';" readonly><?php $this->debug_info->render(); ?></textarea>
                                <p id="trp_debug_msg"></p>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

        </div>
        <?php
    }

}
