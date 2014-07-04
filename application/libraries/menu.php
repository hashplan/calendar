<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Menu {

	protected static $activeUrl = null;

	public static function isActive($path, $ifTrueClass = 'active', $ifFalseClass = '') {

		$result = $ifTrueClass;

		if ($path != '/'){
			$menuUrl = explode('/', base_url($path));
			if (is_null(self::$activeUrl)) {
				$current_url = explode('/', current_url());
				foreach ($current_url as $key => $value){
					if(!isset($menuUrl[$key]) OR $value != $menuUrl[$key]){
						$result = $ifFalseClass;
						break;
					}
				}
			}
			else {
				$current_url = explode('/', base_url(self::$activeUrl));
				foreach ($current_url as $key => $value){
					if(!isset($menuUrl[$key]) OR $value != $menuUrl[$key]){
						$result = $ifFalseClass;
						break;
					}
				}
			}
		}
		return $result;
	}

	public static function setActive($path) {
		self::$activeUrl = $path;
	}

}