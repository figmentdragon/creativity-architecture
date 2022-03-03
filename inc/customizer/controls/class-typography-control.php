<?php
/**
 * The typography Customizer control.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Typography_Customize_Control' ) ) {
	/**
	 * Create the typography elements control.
	 *
	 */
	class Typography_Customize_Control extends WP_Customize_Control {
		public $type = 'customizer-typography';

		public function enqueue() {
			wp_enqueue_script( 'typography-selectWoo', trailingslashit( get_template_directory_uri() )  . 'inc/customizer/controls/js/selectWoo.min.js', array( 'customize-controls', 'jquery' ), 'VERSION', true );
			wp_enqueue_style( 'typography-selectWoo', trailingslashit( get_template_directory_uri() )  . 'inc/customizer/controls/css/selectWoo.min.css', array(), 'VERSION' );

			wp_enqueue_script( 'typography-customizer', trailingslashit( get_template_directory_uri() )  . 'inc/customizer/controls/js/typography-customizer.js', array( 'customize-controls', 'typography-selectWoo' ), 'VERSION', true );
			wp_enqueue_style( 'typography-customizer', trailingslashit( get_template_directory_uri() )  . 'inc/customizer/controls/css/typography-customizer.css', array(), 'VERSION' );
		}

		public function to_json() {
			parent::to_json();

			$number_of_fonts = apply_filters( 'number_of_fonts', 200 );
			$this->json[ 'default_fonts_title'] = __( 'System fonts', 'TheCreativityArchitect' );
			$this->json[ 'google_fonts_title'] = __( 'Google fonts', 'TheCreativityArchitect' );
			$this->json[ 'google_fonts' ] = apply_filters( 'typography_customize_list', get_all_google_fonts( $number_of_fonts ) );
			$this->json[ 'default_fonts' ] = typography_default_fonts();
			$this->json[ 'family_title' ] = esc_html__( 'Font family', 'TheCreativityArchitect' );
			$this->json[ 'weight_title' ] = esc_html__( 'Font weight', 'TheCreativityArchitect' );
			$this->json[ 'transform_title' ] = esc_html__( 'Text transform', 'TheCreativityArchitect' );
			$this->json[ 'category_title' ] = '';
			$this->json[ 'variant_title' ] = esc_html__( 'Variants', 'TheCreativityArchitect' );

			foreach ( $this->settings as $setting_key => $setting_id ) {
				$this->json[ $setting_key ] = array(
					'link'  => $this->get_link( $setting_key ),
					'value' => $this->value( $setting_key ),
					'default' => isset( $setting_id->default ) ? $setting_id->default : '',
					'id' => isset( $setting_id->id ) ? $setting_id->id : ''
				);

				if ( 'weight' === $setting_key ) {
					$this->json[ $setting_key ]['choices'] = $this->get_font_weight_choices();
				}

				if ( 'transform' === $setting_key ) {
					$this->json[ $setting_key ]['choices'] = $this->get_font_transform_choices();
				}
			}
		}

		public function content_template() {
			?>
			<?php if ( '' !== data.label ) { ?>
				<span class="customize-control-title">{{ data.label }}</span>
			<?php } ?>
			<?php if ( 'undefined' !== typeof ( data.family ) ) { ?>
				<div class="font-family">
					<label>
						<select {{{ data.family.link }}} data-category="{{{ data.category.id }}}" data-variants="{{{ data.variant.id }}}" style="width:100%;">
							<optgroup label="{{ data.default_fonts_title }}">
								<?php foreach ( $key in data.default_fonts ) { ?>
									<?php var name = data.default_fonts[ key ].split(',')[0]; ?>
									<option value="{{ data.default_fonts[ key ] }}"  <?php if ( data.default_fonts[ key ] === data.family.value ) { ?>selected="selected"<?php } ?>>{{ name }}</option>
								<?php } ?>
							</optgroup>
							<optgroup label="{{ data.google_fonts_title }}">
								<?php for ( var key in data.google_fonts ) { ?>
									<option value="{{ data.google_fonts[ key ].name }}"  <?php if ( data.google_fonts[ key ].name === data.family.value ) { ?>selected="selected"<?php } ?>>{{ data.google_fonts[ key ].name }}</option>
								<?php } ?>
							</optgroup>
						</select>
						<?php if ( '' !== data.family_title ) { ?>
							<p class="description">{{ data.family_title }}</p>
						<?php } ?>
					</label>
				</div>
			<?php } ?>

			<?php if ( 'undefined' !== typeof ( data.variant ) ) { ?>
				<?php
				var id = data.family.value.split(' ').join('_').toLowerCase();
				var font_data = data.google_fonts[id];
				var variants = '';
				if ( typeof font_data !== 'undefined' ) {
					variants = font_data.variants;
				}

				if ( null === data.variant.value ) {
					data.variant.value = data.variant.default;
				}
				?>
				<div id={{{ data.variant.id }}}" class="font-variant" data-saved-value="{{ data.variant.value }}">
					<label>
						<select name="{{{ data.variant.id }}}" multiple class="typography-multi-select" style="width:100%;" {{{ data.variant.link }}}>
							<?php _.each( variants, function( label, choice ) { ?>
								<option value="{{ label }}">{{ label }}</option>
							<?php } ) ?>
						</select>

						<?php if ( '' !== data.variant_title ) { ?>
							<p class="description">{{ data.variant_title }}</p>
						<?php } ?>
					</label>
				</div>
			<?php } ?>

			<?php if ( 'undefined' !== typeof ( data.category ) ) { ?>
				<div class="font-category">
					<label>
							<input name="{{{ data.category.id }}}" type="hidden" {{{ data.category.link }}} value="{{{ data.category.value }}}" class="hidden-input" />
						<?php if ( '' !== data.category_title ) { ?>
							<p class="description">{{ data.category_title }}</p>
						<?php } ?>
					</label>
				</div>
			<?php } ?>

			<?php if ( 'undefined' !== typeof ( data.weight ) ) { ?>
				<div class="font-weight">
					<label>
						<select {{{ data.weight.link }}}>

							<?php _.each( data.weight.choices, function( label, choice ) { ?>

								<option value="{{ choice }}" <?php if ( choice === data.weight.value ) { ?> selected="selected" <?php } ?>>{{ label }}</option>

							<?php } ) ?>

						</select>
						<?php if ( '' !== data.weight_title ) { ?>
							<p class="description">{{ data.weight_title }}</p>
						<?php } ?>
					</label>
				</div>
			<?php } ?>

			<?php if ( 'undefined' !== typeof ( data.transform ) ) { ?>
				<div class="font-transform">
					<label>
						<select {{{ data.transform.link }}}>

							<?php _.each( data.transform.choices, function( label, choice ) { ?>

								<option value="{{ choice }}" <?php if ( choice === data.transform.value ) { ?> selected="selected" <?php } ?>>{{ label }}</option>

							<?php } ) ?>

						</select>
						<?php if ( '' !== data.transform_title ) { ?>
							<p class="description">{{ data.transform_title }}</p>
						<?php } ?>
					</label>
				</div>
			<?php } ?>
			<?php
		}

		public function get_font_weight_choices() {
			return array(
				'normal' => esc_html( 'normal' ),
				'bold' => esc_html( 'bold' ),
				'100' => esc_html( '100' ),
				'200' => esc_html( '200' ),
				'300' => esc_html( '300' ),
				'400' => esc_html( '400' ),
				'500' => esc_html( '500' ),
				'600' => esc_html( '600' ),
				'700' => esc_html( '700' ),
				'800' => esc_html( '800' ),
				'900' => esc_html( '900' ),
			);
		}

		public function get_font_transform_choices() {
			return array(
				'none' => esc_html( 'none' ),
				'capitalize' => esc_html( 'capitalize' ),
				'uppercase' => esc_html( 'uppercase' ),
				'lowercase' => esc_html( 'lowercase' ),
			);
		}
	}
}
