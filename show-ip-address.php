<?php
/*
 * Plugin name: Show IP address
 * Plugin URI: http://www.keith-griffiths.com
 * Description: A simple plugin to show your IP address information on any of your pages, posts or widgets. Shows your IP address on your Dashboard.
 * Version: 1.0
 * Author: Keith Griffiths
 * Author URI: http://www.keith-griffiths.com
 * Licence: GPLv2
 */

/* Copyright 2015 Keith Griffiths (email : info@keith-griffiths.com)
   
   This program is free software; you can redistribute it and/or modify

   it under the terms of the GNU General Public License, version 2,  

   as published by the Free Software Foundation.


   This program is distributed in the hope that it will be useful,

   but WITHOUT ANY WARRANTY; without even the implied warranty of

   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
   
   See the GNU General Public License for more details.

*/

if(is_admin())
	{	
		function ip_dashboard_widget_function()
		{
			// admin ip address
			$admin_ip_address = $_SERVER['REMOTE_ADDR'];
			if(!$admin_ip_address)
				$admin_ip_address = 'unknown';
			
			// admin hostname
			$admin_hostname = @gethostbyaddr($admin_ip_address);
			if(!$admin_hostname OR $admin_hostname == $admin_ip_address)
				$admin_hostname = 'Not known';
			
			// display information
			echo '<div style="display:table; width: 100%;">';
			
			echo '<div style="display:table-cell;"><big><strong>'.$admin_ip_address.'</strong></big></div>';
			
			if($admin_hostname != 'unknown')
				echo '<div style="display:table-cell; text-align: right;"><small>('.__('hostname', 'admin-ip-address').' : '.$admin_hostname.')</small></div>';
			
			echo "</div>\n";
		}
		
		// function dashboard widget
		function ip_add_dashboard_widgets()
		{
			wp_add_dashboard_widget('ip_dashboard_widget', __('Your IP Address & Hostname', 'admin-ip-address'), 'ip_dashboard_widget_function');
		}
		
		add_action('wp_dashboard_setup', 'ip_add_dashboard_widgets' );

	}		
		
if(is_admin())
	{
		// add a Contact link on your plugin page
		function user_ip_contact_link($links)
		{ 
			$contact_link = '<a href="http://www.keith-griffiths.com/contact-me" target="_blank">Contact Developer</a>'; 
			//array_unshift($links, $contact_link);
			array_push($links, $contact_link); 
			return $links; 
		}
		
		$plugin = plugin_basename(__FILE__); 
		add_filter("plugin_action_links_$plugin", 'user_ip_contact_link' );
	}
 
	function get_the_user_ip() {

	if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {

	//check ip from the web
	$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
	
	//check ip from proxy
	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
	$ip = $_SERVER['REMOTE_ADDR'];
	}
	return apply_filters( 'wpb_get_ip', $ip );
	}
	 
	add_shortcode('show_ip', 'get_the_user_ip'); 

?>