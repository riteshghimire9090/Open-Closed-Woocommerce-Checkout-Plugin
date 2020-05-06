<?php
/**
 * Plugin Name:       Open Closed Woocommerce Checkout By Ritesh Ghimire
 * Plugin URI:        https://riteshghimire.com/
 * Description:       This is simple plugin which helps to closed the woocommerce checkout in Store Closed day!
 * Version:           1.0.0
 * Requires at least: 5.0
 * Requires PHP:      7.2
 * Author:            Ritesh Ghimire
 * Author URI:        https://riteshghimire.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       Open_Closed_Day
 * Domain Path:       /languages
 */


if(in_array('woocommerce/woocommerce.php',get_option( 'active_plugins')))
{
    if(!class_exists("Open_Closed_Day")){
        class Open_Closed_Day
        {
            public function __construct()
            {
              //  var_dump(get_option( 'active_plugins'));

              //print an admin notice to the screen

              add_action('admin_notices',[$this,'my_admin_notice']);
              add_filter("woocommerce_settings_tabs_array",[$this,'add_settings_tab'],50);
              add_action( 'woocommerce_settings_opening_hours', [$this,'add_settings'],50);
              add_action( 'woocommerce_update_options_opening_hours', [$this,'update_settings'],50);
              add_action( 'wp',[$this,'maybe_closed_shop'],30 );
            }
            //print in admin notice
            public function my_admin_notice()
            {
                ?>
                        
                        <!-- <div class="notice notice-error is-dismissible">
                    <p><?php _e( 'Done!', 'Open_Closed_Day' ); ?></p>
                </div> -->
                <?php    
            }
            //add_settings_tabs
            public function add_settings_tab($settings_tabs)
            {
              //  var_dump($settings_tabs);
                $settings_tabs['opening_hours']=__('Opening Hours','Open_Closed_Day');
                return $settings_tabs;
            }

            public function add_settings()
            {
                woocommerce_admin_fields(self::get_settings());
            }
            public function update_settings()
            {
                woocommerce_update_options(self::get_settings());
            }
            //Adding Tabs in Woo commerce setting tabs!
            public function get_settings()
            {

                $settings=[
                    'section_tittle'=>
                    [ 
                        'name'=>__('Opening Hours','Open_Closed_Day'),
                        'type'=>'title'
                    ],
                    'closed_saturday'=>
                    [ 
                        'name'=>__('Closing on Saturday','Open_Closed_Day'),
                        'type'=>'checkbox',
                        'desc'=>__('Disable the checkout on Satuarday','Open_Closed_Day'),
                        'id'=>'Open_Closed_Day_closed_saturday'
                    ],

                    'closed_sunday'=>
                    [ 
                        'name'=>__('Closing on Sunday','Open_Closed_Day'),
                        'type'=>'checkbox',
                        'desc'=>__('Disable the checkout on Sunday','Open_Closed_Day'),
                        'id'=>'Open_Closed_Day_closed_sunday'
                    ],
                    'closed_monday'=>
                    [ 
                        'name'=>__('Closing on Monday','Open_Closed_Day'),
                        'type'=>'checkbox',
                        'desc'=>__('Disable the checkout on Monday','Open_Closed_Day'),
                        'id'=>'Open_Closed_Day_closed_monday'
                    ],
                    'closed_tuesday'=>
                    [ 
                        'name'=>__('Closing on Tuesday','Open_Closed_Day'),
                        'type'=>'checkbox',
                        'desc'=>__('Disable the checkout on Saturday','Open_Closed_Day'),
                        'id'=>'Open_Closed_Day_closed_tuesday'
                    ],
                    'closed_wednesday'=>
                    [ 
                        'name'=>__('Closing on Wednesday','Open_Closed_Day'),
                        'type'=>'checkbox',
                        'desc'=>__('Disable the checkout on Wednesday','Open_Closed_Day'),
                        'id'=>'Open_Closed_Day_closed_wednesday'
                    ],
                    'closed_thursday'=>
                    [ 
                        'name'=>__('Closing on Saturday','Open_Closed_Day'),
                        'type'=>'checkbox',
                        'desc'=>__('Disable the checkout on Thursday','Open_Closed_Day'),
                        'id'=>'Open_Closed_Day_closed_thursday'
                    ],
                    'closed_friday'=>
                    [ 
                        'name'=>__('Closing on Friday','Open_Closed_Day'),
                        'type'=>'checkbox',
                        'desc'=>__('Disable the checkout on Friday','Open_Closed_Day'),
                        'id'=>'Open_Closed_Day_closed_friday'
                    ],
                    'redirect_url'=>
                    [ 
                        'name'=>__('Redirect Url','Open_Closed_Day'),
                        'type'=>'url',
                        'desc'=>__('Paste link of page where to redirect if Clients do checkout','Open_Closed_Day'),
                        'id'=>'Open_Closed_Day_closed_saturday_redirect_url'
                    ],
                    'section_end'=>
                    [ 
                     
                        'type'=>'sectionend',
                        'id'=>'Open_Closed_Day_opening_hours_section_end'
                    ],
                ];
                return $settings;
            }

            public function maybe_closed_shop(){
               
                $Open_Closed_Day_closed_saturday = get_option('Open_Closed_Day_closed_saturday') == "yes";
                $Open_Closed_Day_closed_sunday = get_option('Open_Closed_Day_closed_sunday') == "yes";
                $Open_Closed_Day_closed_monday = get_option('Open_Closed_Day_closed_monday') == "yes";
                $Open_Closed_Day_closed_tuesday = get_option('Open_Closed_Day_closed_tuesday') == "yes";
                $Open_Closed_Day_closed_wednesday = get_option('Open_Closed_Day_closed_wednesday') == "yes";
                $Open_Closed_Day_closed_thursday = get_option('Open_Closed_Day_closed_thursday') == "yes";
                $Open_Closed_Day_closed_friday = get_option('Open_Closed_Day_closed_friday') == "yes";
               
                if(is_checkout()&& $Open_Closed_Day_closed_saturday && date('l')=="Saturday")
                {
                    header('Location: '.get_option('Open_Closed_Day_closed_saturday_redirect_url'));
                   // wp_safe_redirect();  
                }
                if(is_checkout()&& $Open_Closed_Day_closed_sunday && date('l')=="Sunday")
                {
                    header('Location: '.get_option('Open_Closed_Day_closed_saturday_redirect_url'));
                   // wp_safe_redirect();  
                }
                if(is_checkout()&& $Open_Closed_Day_closed_monday && date('l')=="Monday")
                {
                    header('Location: '.get_option('Open_Closed_Day_closed_saturday_redirect_url'));
                   // wp_safe_redirect();  
                }
                if(is_checkout()&& $Open_Closed_Day_closed_tuesday && date('l')=="Tuesday")
                {
                    header('Location: '.get_option('Open_Closed_Day_closed_saturday_redirect_url'));
                   // wp_safe_redirect();  
                }
                if(is_checkout()&& $Open_Closed_Day_closed_wednesday && date('l')=="Wednesday")
                {
                    header('Location: '.get_option('Open_Closed_Day_closed_saturday_redirect_url'));
                   // wp_safe_redirect();  
                }
                if(is_checkout()&& $Open_Closed_Day_closed_thursday && date('l')=="Thursday")
                {
                    header('Location: '.get_option('Open_Closed_Day_closed_saturday_redirect_url'));
                   // wp_safe_redirect();  
                }
                if(is_checkout()&& $Open_Closed_Day_closed_friday && date('l')=="Friday")
                {
                    header('Location: '.get_option('Open_Closed_Day_closed_saturday_redirect_url'));
                   // wp_safe_redirect();  
                }

            }


        }

        $GLOBALS['Open_Closed_Day']  =   new Open_Closed_Day();
    }
}


