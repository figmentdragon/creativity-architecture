<?php
/**
 * Builds filterable classes throughout the theme.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'right_sidebar_class' ) ) {
	/**
	 * Display the classes for the sidebar.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function right_sidebar_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV
		echo 'class="' . esc_attr( join( ' ', get_right_sidebar_class( $class ) ) ) . '"'; 
	}
}

if ( ! function_exists( 'get_right_sidebar_class' ) ) {
	/**
	 * Retrieve the classes for the sidebar.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function get_right_sidebar_class( $class = '' ) {

		$classes = array();

		if ( !empty($class) ) {
			if ( !is_array( $class ) )
				$class = preg_split('#\s+#', $class);
			$classes = array_merge($classes, $class);
		}

		$classes = array_map('esc_attr', $classes);

		return apply_filters('right_sidebar_class', $classes, $class);
	}
}

if ( ! function_exists( 'left_sidebar_class' ) ) {
	/**
	 * Display the classes for the sidebar.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function left_sidebar_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV
		echo 'class="' . esc_attr( join( ' ', get_left_sidebar_class( $class ) ) ) . '"'; 
	}
}

if ( ! function_exists( 'get_left_sidebar_class' ) ) {
	/**
	 * Retrieve the classes for the sidebar.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function get_left_sidebar_class( $class = '' ) {

		$classes = array();

		if ( !empty($class) ) {
			if ( !is_array( $class ) )
				$class = preg_split('#\s+#', $class);
			$classes = array_merge($classes, $class);
		}

		$classes = array_map('esc_attr', $classes);

		return apply_filters('left_sidebar_class', $classes, $class);
	}
}

if ( ! function_exists( 'content_class' ) ) {
	/**
	 * Display the classes for the content.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function content_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV
		echo 'class="' . esc_attr( join( ' ', get_content_class( $class ) ) ) . '"'; 
	}
}

if ( ! function_exists( 'get_content_class' ) ) {
	/**
	 * Retrieve the classes for the content.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function get_content_class( $class = '' ) {

		$classes = array();

		if ( !empty($class) ) {
			if ( !is_array( $class ) )
				$class = preg_split('#\s+#', $class);
			$classes = array_merge($classes, $class);
		}

		$classes = array_map('esc_attr', $classes);

		return apply_filters('content_class', $classes, $class);
	}
}

if ( ! function_exists( 'header_class' ) ) {
	/**
	 * Display the classes for the header.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function header_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV
		echo 'class="' . esc_attr( join( ' ', get_header_class( $class ) ) ) . '"'; 
	}
}

if ( ! function_exists( 'get_header_class' ) ) {
	/**
	 * Retrieve the classes for the content.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function get_header_class( $class = '' ) {

		$classes = array();

		if ( !empty($class) ) {
			if ( !is_array( $class ) )
				$class = preg_split('#\s+#', $class);
			$classes = array_merge($classes, $class);
		}

		$classes = array_map('esc_attr', $classes);

		return apply_filters('header_class', $classes, $class);
	}
}

if ( ! function_exists( 'inside_header_class' ) ) {
	/**
	 * Display the classes for inside the header.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function inside_header_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV
		echo 'class="' . esc_attr( join( ' ', get_inside_header_class( $class ) ) ) . '"'; 
	}
}

if ( ! function_exists( 'get_inside_header_class' ) ) {
	/**
	 * Retrieve the classes for inside the header.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function get_inside_header_class( $class = '' ) {

		$classes = array();

		if ( !empty($class) ) {
			if ( !is_array( $class ) )
				$class = preg_split('#\s+#', $class);
			$classes = array_merge($classes, $class);
		}

		$classes = array_map('esc_attr', $classes);

		return apply_filters('inside_header_class', $classes, $class);
	}
}

if ( ! function_exists( 'container_class' ) ) {
	/**
	 * Display the classes for the container.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function container_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV
		echo 'class="' . esc_attr( join( ' ', get_container_class( $class ) ) ) . '"'; 
	}
}

if ( ! function_exists( 'get_container_class' ) ) {
	/**
	 * Retrieve the classes for the content.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function get_container_class( $class = '' ) {

		$classes = array();

		if ( !empty($class) ) {
			if ( !is_array( $class ) )
				$class = preg_split('#\s+#', $class);
			$classes = array_merge($classes, $class);
		}

		$classes = array_map('esc_attr', $classes);

		return apply_filters('container_class', $classes, $class);
	}
}

if ( ! function_exists( 'navigation_class' ) ) {
	/**
	 * Display the classes for the navigation.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function navigation_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV
		echo 'class="' . esc_attr( join( ' ', get_navigation_class( $class ) ) ) . '"'; 
	}
}

if ( ! function_exists( 'get_navigation_class' ) ) {
	/**
	 * Retrieve the classes for the navigation.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function get_navigation_class( $class = '' ) {

		$classes = array();

		if ( !empty($class) ) {
			if ( !is_array( $class ) )
				$class = preg_split('#\s+#', $class);
			$classes = array_merge($classes, $class);
		}

		$classes = array_map('esc_attr', $classes);

		return apply_filters('navigation_class', $classes, $class);
	}
}

if ( ! function_exists( 'inside_navigation_class' ) ) {
	/**
	 * Display the classes for the inner navigation.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function inside_navigation_class( $class = '' ) {
		$classes = array();

		if ( !empty($class) ) {
			if ( !is_array( $class ) )
				$class = preg_split('#\s+#', $class);
			$classes = array_merge($classes, $class);
		}

		$classes = array_map('esc_attr', $classes);

		$return = apply_filters('inside_navigation_class', $classes, $class);

		// Separates classes with a single space, collates classes for post DIV
		echo 'class="' . esc_attr( join( ' ', $return ) ) . '"'; 
	}
}

if ( ! function_exists( 'menu_class' ) ) {
	/**
	 * Display the classes for the navigation.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function menu_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV
		echo 'class="' . esc_attr( join( ' ', get_menu_class( $class ) ) ) . '"'; 
	}
}

if ( ! function_exists( 'get_menu_class' ) ) {
	/**
	 * Retrieve the classes for the navigation.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function get_menu_class( $class = '' ) {

		$classes = array();

		if ( !empty($class) ) {
			if ( !is_array( $class ) )
				$class = preg_split('#\s+#', $class);
			$classes = array_merge($classes, $class);
		}

		$classes = array_map('esc_attr', $classes);

		return apply_filters('menu_class', $classes, $class);
	}
}

if ( ! function_exists( 'main_class' ) ) {
	/**
	 * Display the classes for the <main> container.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function main_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV
		echo 'class="' . esc_attr( join( ' ', get_main_class( $class ) ) ) . '"'; 
	}
}

if ( ! function_exists( 'get_main_class' ) ) {
	/**
	 * Retrieve the classes for the footer.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function get_main_class( $class = '' ) {

		$classes = array();

		if ( !empty($class) ) {
			if ( !is_array( $class ) )
				$class = preg_split('#\s+#', $class);
			$classes = array_merge($classes, $class);
		}

		$classes = array_map('esc_attr', $classes);

		return apply_filters('main_class', $classes, $class);
	}
}

if ( ! function_exists( 'footer_class' ) ) {
	/**
	 * Display the classes for the footer.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function footer_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV
		echo 'class="' . esc_attr( join( ' ', get_footer_class( $class ) ) ) . '"'; 
	}
}

if ( ! function_exists( 'get_footer_class' ) ) {
	/**
	 * Retrieve the classes for the footer.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function get_footer_class( $class = '' ) {

		$classes = array();

		if ( !empty($class) ) {
			if ( !is_array( $class ) )
				$class = preg_split('#\s+#', $class);
			$classes = array_merge($classes, $class);
		}

		$classes = array_map('esc_attr', $classes);

		return apply_filters('footer_class', $classes, $class);
	}
}

if ( ! function_exists( 'inside_footer_class' ) ) {
	/**
	 * Display the classes for the footer.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function inside_footer_class( $class = '' ) {
		$classes = array();

		if ( !empty($class) ) {
			if ( !is_array( $class ) )
				$class = preg_split('#\s+#', $class);
			$classes = array_merge($classes, $class);
		}

		$classes = array_map('esc_attr', $classes);

		$return = apply_filters( 'inside_footer_class', $classes, $class );

		// Separates classes with a single space, collates classes for post DIV
		echo 'class="' . esc_attr( join( ' ', $return ) ) . '"'; 
	}
}

if ( ! function_exists( 'top_bar_class' ) ) {
	/**
	 * Display the classes for the top bar.
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function top_bar_class( $class = '' ) {
		$classes = array();

		if ( !empty($class) ) {
			if ( !is_array( $class ) )
				$class = preg_split('#\s+#', $class);
			$classes = array_merge($classes, $class);
		}

		$classes = array_map('esc_attr', $classes);

		$return = apply_filters( 'top_bar_class', $classes, $class );

		// Separates classes with a single space, collates classes for post DIV
		echo 'class="' . esc_attr( join( ' ', $return ) ) . '"'; 
	}
}
