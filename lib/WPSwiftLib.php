<?php

if (!class_exists('WPSwiftLib')) {

class WPSwiftLib {

	static function showStringSetting($name, $value, $description, $comment = '') {
		
		$return = '<tr> ' . PHP_EOL; 
		$return .= '<th scope="row"><label for="' . $name . '">' . $description . '</label></th>' . PHP_EOL;
		$return .= '<td><input id="' . $name . '" type="text" name="' . $name . '" value="' . $value . '" /></td>' . PHP_EOL;
		
		if (!empty($comment)) {
	
			$return .= '<td>' . $comment . '</td>' . PHP_EOL;
		}

		$return .= '</tr>' . PHP_EOL;

		return $return;
	}
	
	static function showCheckboxSetting($name, $is_checked, $description, $comment = '') {

		$checked_statement = ($is_checked == true) ? ' checked' : '';

		$return = '<tr>' . PHP_EOL;
		$return .= '<th scope="row"><label for="' . $name . '">' . $description . '</label></th>' . PHP_EOL;
                $return .= '<td><input id="' . $name . '" type="checkbox" name="' . $name . '" class="checkbox"' . $checked_statement . ' /></td>' . PHP_EOL;

		if (!empty($comment)) {

                        $return .= '<td>' . $comment . '</td>' . PHP_EOL;
                }

		$return .= '</tr>' . PHP_EOL;

		return $return;
	
	}

	static function showWidgetStringSetting($instance, $name, $value, $description) {

		$return = '<p>' . PHP_EOL;
		$return .= '<label for="' . $instance->get_field_name($name) . '">' . $description . '</label>' . PHP_EOL;
		$return .= '<input id="' . $instance->get_field_id($name) . '" type="text" name="' . $instance->get_field_name($name) . '" style="width: 100%;" value="' . $value . '" />' . PHP_EOL;
		$return .= '</p>' . PHP_EOL;

		return $return;
	}

	static function showWidgetCheckboxSetting ($instance, $name, $is_checked, $description) {
		
		$checked_statement = ($is_checked == true) ? ' checked' : '';

		$return = '<p>' . PHP_EOL;
		$return .= '<input id="' . $instance->get_field_id($name) . '" type="checkbox" class="checkbox" name="' . $instance->get_field_name($name) . '"' . $checked_statement . ' />' . PHP_EOL;
		$return .= '<label for="' . $instance->get_field_name($name) . '">' . $description . '</label>' . PHP_EOL;
		$return .= '</p>' . PHP_EOL;

		return $return;

	}

	static function requireScriptsFromDirectory ($directory) {

		if ($directory_handler = opendir($directory)) {

			while (false !== ($script = readdir($directory_handler))) {

		                if ($script != '.' && $script != '..' && preg_match('/.php$/', $script)) {

                		        require_once ($directory . $script);

		                }
		        }

		        closedir($directory_handler);

		}

	}
	
}

}
