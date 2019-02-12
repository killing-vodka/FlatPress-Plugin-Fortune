<?php
/*
Plugin Name: Fortune
Version: 0.3
Plugin URI: https://github.com/pozharlab/FlatPress-Plugin-Fortune
Description: Displays a pseudorandom message.
Author: Giovanni Forte
Author URI: http://www.vodkafilm.it
*/

function plugin_fortune_widget() {

	$rqcfg = plugin_getoptions('fortune');
	$input = $rqcfg['rqform'];

	$line = array_rand($input);

	$quote['subject'] = Fortune;
	$quote['content'] = $input[$line];

	return $quote;
}


register_widget('fortune', 'Fortune', 'plugin_fortune_widget');

if (class_exists('AdminPanelAction')){
	/**
	 * Provides an admin panel entry for Fortune.
	 */
	class admin_plugin_fortune extends AdminPanelAction {
		var $langres = 'plugin:fortune';
		
		/**
		 * Initializes this panel.
		 */
		function setup() {
			$this->smarty->assign('admin_resource', "plugin:fortune/admin.plugin.fortune");
		}
		
		/**
		 * Setups the default panel.
		 */
		function main() {
			$rqcfg = plugin_getoptions('fortune');
			
			$rqcfg['rqform'] = isset($rqcfg['rqform']) && is_array($rqcfg['rqform'])
				? implode("\n", $rqcfg['rqform'])
				: '';

			$this->smarty->assign('rqcfg', $rqcfg);
		}
		
		/**
		 * Will be executed when the form is send.
		 */
		function onsubmit() {
			if ($_POST['rqform']){
				$list = isset($_POST['rqform'])
					? stripslashes($_POST['rqform'])
					: '';
				$list = str_replace("\r", "\n", $list);
				$list = strip_tags($list);
				$list = explode("\n", $list);
				$list = array_filter($list, array($this, '_array_filter'));
				plugin_addoption('fortune', 'rqform', $list);
				plugin_saveoptions('fortune');
				$this->smarty->assign('success', 1);
			} else {
			 	$this->smarty->assign('success', -1);
			}
			return 2;
		}
				/**
		 * Array filter callback function. Culls empty array values.
		 * Life is hell, but some people can help you :)
		 *
		 * @param string $str
		 * @return boolean
		 */
		function _array_filter($str) {
			return strlen(trim($str)) > 0;
		}
		
	}
	admin_addpanelaction('plugin', 'fortune', true);
}

?>
