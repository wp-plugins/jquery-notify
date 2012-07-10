<?php
/*
Plugin Name: jQuery Notify
Plugin URI: http://jquery-notify.mindsharelabs.com/
Description: An attractive, lightweight, and highly configurable jQuery notification pane.
Version: 0.1
Author: Bryce Corkins / Mindshare Studios
Author URI: http://mind.sh/are
License: GPL2

    Copyright 2012  Mindshare Studios, Inc.  (email : info@mindsharestudios.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/
if (!class_exists("jQuery_Notify")) {
	class jQuery_Notify {

		private $enable_jqnm;
		private $in_footer = true;
		
		//SHORTCODE PROPERTIES
		private $content;
		private $style;
		private $speed;
		private $delay;
	
		public function __construct() {
			add_shortcode( 'jq_notify', array($this, 'shortcode'));
			add_action('init', array($this, 'register_scripts'));
			add_action('wp_footer', array($this, 'print_scripts'));
		}

		public function register_scripts() {
			wp_register_script(
					'jqnm-script',
					plugins_url('/script.js', __FILE__),
					array('jquery'),
					'1.0',
					$this->in_footer);
		}
	
		public function print_scripts() {
			$admin_offset = 0;
			
			if ( ! $this->enable_jqnm )
				return;
				
			if(is_admin_bar_showing())
				$admin_offset = 28;
		
			$script_options = array( 'offset' => $admin_offset, 'speed' => $this->speed, 'delay' => $this->delay );
		
			wp_enqueue_style('jqnm-style', plugins_url('/style.css', __FILE__));
			wp_localize_script('jqnm-script', 'jqnm_script_vars', $script_options);		
			wp_print_scripts('jqnm-script');
			add_action('wp_footer', array($this,'jqnm_output')); 
		}
		
		//TEMPLATE TAG
		public function template_tag($content, $style, $speed, $delay) {
			$this->enable_jqnm = true;
			$this->content = $content;
			$this->style = $style;
			$this->speed = $speed;
			$this->delay = $delay;
		
		return $this->print_scripts();
		}

		// SHORTCODE
		public function shortcode( $atts, $content = null ) {
			$this->enable_jqnm = true;
			$this->content = $content;

			extract( shortcode_atts( array(
		      'style' => 'default',
			  'speed' => 500,
		      'delay' => 1000
		      ), $atts ) );
		
			$this->style = $style;
			$this->speed = $speed;
			$this->delay = $delay;
		
		return $this->print_scripts();
		}


		//OUTPUT HTML
		public function jqnm_output() { ?>
			<div class="jqnm_<?php echo $this->style; ?> jqnm_message" title="click to dismiss">
				<?php
				 	echo $this->content;
				?>
			</div>
	
		<?php }

	} // End Class jQuery_Notify
}

if (class_exists("jQuery_Notify")) {
	$jquery_notification = new jQuery_Notify();

	function jq_notify($content, $style, $speed, $delay)  
	{  
	    $jquery_notification = new jQuery_Notify();
	    $jquery_notification->template_tag($content, $style, $speed, $delay);  
	}

}

?>