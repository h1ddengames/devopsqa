<?php
/**
 * Customizer custom controls
 *
 * @package Theme Palace
 * @subpackage Corpopress
 * @since Corpopress 1.0.0
 */


if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

/**
 * Customize Control for Taxonomy Select.
 *
 * @since Corpopress 1.0.0
 *
 * @see WP_Customize_Control
 */
class Corpopress_Dropdown_Taxonomies_Control extends WP_Customize_Control {

	/**
	 * Control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'dropdown-taxonomies';

	/**
	 * Taxonomy.
	 *
	 * @access public
	 * @var string
	 */
	public $taxonomy = '';

	/**
	 * Constructor.
	 *
	 * @since Corpopress 1.0.0
	 *
	 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
	 * @param string               $id      Control ID.
	 * @param array                $args    Optional. Arguments to override class property defaults.
	 */
	public function __construct( $manager, $id, $args = array() ) {

		$taxonomy = 'category';
		if ( isset( $args['taxonomy'] ) ) {
			$taxonomy_exist = taxonomy_exists( esc_attr( $args['taxonomy'] ) );
			if ( true === $taxonomy_exist ) {
				$taxonomy = esc_attr( $args['taxonomy'] );
			}
		}
		$args['taxonomy'] = $taxonomy;
		$this->taxonomy = esc_attr( $taxonomy );

		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Render content.
	 *
	 * @since Corpopress 1.0.0
	 */
	public function render_content() {

		$tax_args = array(
			'hierarchical' => 0,
			'taxonomy'     => $this->taxonomy,
		);
		$taxonomies = get_categories( $tax_args );

	?>
    <label>
      <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
      <?php if ( ! empty( $this->description ) ) : ?>
      	<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
      <?php endif; ?>
       <select <?php $this->link(); ?>>
			<?php
			printf( '<option value="%s" %s>%s</option>', '', selected( $this->value(), '', false ), '--None--' );
			?>
			<?php if ( ! empty( $taxonomies ) ) :  ?>
            <?php foreach ( $taxonomies as $key => $tax ) :  ?>
				<?php
				printf( '<option value="%s" %s>%s</option>', esc_attr( $tax->term_id ), selected( $this->value(), $tax->term_id, false ), esc_html( $tax->name ) );
				?>
            <?php endforeach ?>
			<?php endif ?>
       </select>
    </label>
    <?php
	}
}

/**
 * Customize Control for Category Select.
 *
 * @since Corpopress 1.0.0
 *
 * @see WP_Customize_Control
 */
class Corpopress_Dropdown_Category_Control extends WP_Customize_Control {

	/**
	 * Control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'dropdown-categories';

	/**
	 * Category.
	 *
	 * @access public
	 * @var string
	 */
	public $taxonomy = '';

	/**
	 * Constructor.
	 *
	 * @since Corpopress 1.0.0
	 *
	 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
	 * @param string               $id      Control ID.
	 * @param array                $args    Optional. Arguments to override class property defaults.
	 */
	public function __construct( $manager, $id, $args = array() ) {

		$taxonomy = 'category';
		if ( isset( $args['taxonomy'] ) ) {
			$taxonomy_exist = taxonomy_exists( esc_attr( $args['taxonomy'] ) );
			if ( true === $taxonomy_exist ) {
				$taxonomy = esc_attr( $args['taxonomy'] );
			}
		}
		$args['taxonomy'] = $taxonomy;
		$this->taxonomy = esc_attr( $taxonomy );

		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Render content.
	 *
	 * @since Corpopress 1.0.0
	 */
	public function render_content() {

		$tax_args = array(
			'hierarchical' => 0,
			'taxonomy'     => $this->taxonomy,
		);
		$taxonomies = get_categories( $tax_args );

	?>
    <label>
      <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
      <?php if ( ! empty( $this->description ) ) : ?>
      	<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
      <?php endif; ?>
       <select <?php $this->link(); ?> multiple>
			<?php
			printf( '<option value="%s" %s>%s</option>', '', selected( $this->value(), '', false ), '--None--' );
			?>
			<?php if ( ! empty( $taxonomies ) ) :  ?>
            <?php foreach ( $taxonomies as $key => $tax ) :  ?>
				<?php
				printf( '<option value="%s" %s>%s</option>', esc_attr( $tax->term_id ), selected( $this->value(), $tax->term_id, false ), esc_html( $tax->name ) );
				?>
            <?php endforeach ?>
			<?php endif ?>
       </select>
    </label>
    <?php
	}
}

//Custom control for any note, use label as output description
class Corpopress_Note_Control extends WP_Customize_Control {
	public $type = 'description';

	public function render_content() {
		echo '<h2 class="description">' . esc_html( $this->label ) . '</h2>';
	}
}


class Corpopress_Switch_Control extends WP_Customize_Control{
	public $type = 'switch';
	public $on_off_label = array();

	public function __construct( $manager, $id, $args = array() ){
        $this->on_off_label = $args['on_off_label'];
        parent::__construct( $manager, $id, $args );
    }

	public function render_content(){
    ?>
	    <span class="customize-control-title">
			<?php echo esc_html( $this->label ); ?>
		</span>

		<?php if( $this->description ){ ?>
			<span class="description customize-control-description">
			<?php echo wp_kses_post( $this->description ); ?>
			</span>
		<?php } ?>

		<?php
			$switch_class = ( $this->value() == 'true' ) ? 'switch-on' : '';
			$on_off_label = $this->on_off_label;
		?>
		<div class="onoffswitch <?php echo esc_attr( $switch_class ); ?>">
			<div class="onoffswitch-inner">
				<div class="onoffswitch-active">
					<div class="onoffswitch-switch"><?php echo esc_html( $on_off_label['on'] ) ?></div>
				</div>

				<div class="onoffswitch-inactive">
					<div class="onoffswitch-switch"><?php echo esc_html( $on_off_label['off'] ) ?></div>
				</div>
			</div>	
		</div>
		<input <?php $this->link(); ?> type="hidden" value="<?php echo esc_attr( $this->value() ); ?>"/>
		<?php
    }
}

class Corpopress_Dropdown_Chooser extends WP_Customize_Control{
	public $type = 'dropdown_chooser';

	public function render_content(){
		if ( empty( $this->choices ) )
                return;
		?>
            <label>
                <span class="customize-control-title">
                	<?php echo esc_html( $this->label ); ?>
                </span>

                <?php if($this->description){ ?>
	            <span class="description customize-control-description">
	            	<?php echo wp_kses_post($this->description); ?>
	            </span>
	            <?php } ?>

                <select class="corpopress-chosen-select" <?php $this->link(); ?>>
                    <?php
                    foreach ( $this->choices as $value => $label )
                        echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->value(), $value, false ) . '>' . esc_html( $label ) . '</option>';
                    ?>
                </select>
            </label>
		<?php
	}
}


/**
 * Create a Radio-Image control
 * 
 * 
 * @link https://github.com/reduxframework/kirki/
 * @link http://ottopress.com/2012/making-a-custom-control-for-the-theme-customizer/
 */
class Corpopress_Custom_Radio_Image_Control extends WP_Customize_Control {
	
	/**
	 * Declare the control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'radio-image';
	
	/**
	 * Render the control to be displayed in the Customizer.
	 */
	public function render_content() {
		if ( empty( $this->choices ) ) {
			return;
		}			
		
		$name = '_customize-radio-' . $this->id;
		?>
		<span class="customize-control-title">
			<?php echo esc_html( $this->label ); ?>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php endif; ?>
		</span>
		<div id="input_<?php echo esc_attr( $this->id ); ?>" class="image">
			<?php foreach ( $this->choices as $value => $label ) : ?>
					<label for="<?php echo esc_attr( $this->id ) . esc_attr( $value ); ?>">
						<input class="image-select" type="radio" value="<?php echo esc_attr( $value ); ?>" id="<?php echo esc_attr( $this->id ) . esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?>>
						<img src="<?php echo esc_html( $label ); ?>" alt="<?php echo esc_attr( $value ); ?>" title="<?php echo esc_attr( $value ); ?>">
						</input>
					</label>
			<?php endforeach; ?>
		</div>
		<?php
	}
}

class Corpopress_Customize_Sortable_Control extends WP_Customize_Control {

  /**
   * Control Type
   */
  public $type = 'sortable';

  /**
   * Enqueue Scripts
   */

  /**
   * Render Settings
   */
  public function render_content() {

    /* if no choices, bail. */
    if ( empty( $this->choices ) ){
      return;
    } ?>

    <?php if ( !empty( $this->label ) ){ ?>
      <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
    <?php } // add label if needed. ?>

    <?php if ( !empty( $this->description ) ){ ?>
      <span class="description customize-control-description"><?php echo esc_attr($this->description); ?></span>
    <?php } // add desc if needed. ?>

    <?php
    /* Data */

    $values = explode( ',', $this->value() );
    $choices = $this->choices;
    $values_choices = (empty($values[0])?$choices:$values);
    ?>

    <ul class="corpopress-sortable-list">

      <?php
       foreach ( $values_choices as $key => $value ){
        $strtolower =strtolower($value);
        $trimmed_value = preg_replace('/\s+/', '', $strtolower);
      ?>

        <li>
            <input class="corpopress-sortable-input sortable-hideme" name="<?php echo esc_attr( $trimmed_value ); ?> " type="hidden"  value="<?php echo esc_attr( $value ); ?>" />
            <span class ="menu-item-handle sortable-span"> <?php echo esc_attr( $value ); ?> </span>
          <i class="dashicons dashicons-menu corpopress-drag-handle"></i>
        </li>

        <?php
          } // end choices.
         ?>

        <li class="sortable-hideme">
          <input class="corpopress-sortable-value" <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>" />
        </li>

    </ul><!-- .cpm-framework-sortable-list -->


  <?php
  }
}


class Corpopress_Icon_Picker extends WP_Customize_Control{
	public $type = 'icon-picker';


	public function render_content(){
		$id = uniqid();
		?>
            <label>
                <span class="customize-control-title">
                	<?php echo esc_html( $this->label ); ?>
                </span>

                <?php if($this->description){ ?>
	            <span class="description customize-control-description">
	            	<?php echo wp_kses_post($this->description); ?>
	            </span>
	            <?php } ?>

                <input id="corpopress-<?php echo esc_attr( $id ); ?>" placeholder="<?php esc_attr_e( 'Click here to select icon', 'corpopress' ); ?>" class="corpopress-icon-picker input" <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>" />
            </label>
		<?php
	}
}

//Custom control for horizontal line
Class Corpopress_Customize_Horizontal_Line extends WP_Customize_Control {
	public $type = 'hr';

	public function render_content() {
		?>
		<div>
			<hr style="border: 1px dotted #72777c;" />
		</div>
		<?php
	}
}

/**
 * Multi input custom control
 *
 * @package WordPress
 * @subpackage inc/customizer
 * @version 1.1.0
 * @author  Denis Žoljom <http://madebydenis.com/>
 * @license https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link https://github.com/dingo-d/wordpress-theme-customizer-extra-custom-controls
 * @since  1.0.0
 */
class Corpopress_Multi_Input_Custom_Control extends WP_Customize_Control {
	/**
	 * Control type
	 *
	 * @var string
	 */
	public $type = 'multi-input';

	/**
	 * Control button text.
	 *
	 * @var string
	 */
	public $button_text;

	/**
	 * Control method
	 *
	 * @since 1.0.0
	 */
	public function render_content() {
		?>
		<label class="customize_multi_input">
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<p><?php echo esc_html( $this->description ); ?></p>
			<input type="hidden" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="customize_multi_value_field" <?php $this->link(); ?> />
			<div class="customize_multi_fields">
				<div class="set">
					<input type="text" value="" class="customize_multi_single_field"/>
					<span class="customize_multi_remove_field"><span class="dashicons dashicons-no-alt"></span></span>
				</div>
			</div>
			<a href="#" class="button button-primary customize_multi_add_field"><?php echo esc_html( $this->button_text ); ?></a>
		</label>
		<?php
	}
}
