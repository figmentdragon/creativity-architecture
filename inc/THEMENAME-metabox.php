<?php
/**
 * THEMENAME Custom Metabox
 *
 * @package THEMENAME
 */

add_action('add_meta_boxes', 'THEMENAME_add_metabox');
function THEMENAME_add_metabox()
{
    add_meta_box(
        'THEMENAME_sidebar_layout', // $id
        'Sidebar Layout', // $title
        'THEMENAME_sidebar_layout_callback', // $callback
        'post', // $page
        'normal', // $context
        'high'); // $priority

    add_meta_box(
        'THEMENAME_sidebar_layout', // $id
        'Sidebar Layout', // $title
        'THEMENAME_sidebar_layout_callback', // $callback
        'page', // $page
        'normal', // $context
        'high'); // $priority

}

$THEMENAME_sidebar_layout = array(
    'right-sidebar' => array(
        'value' => 'right_sidebar',
        'thumbnail' => get_template_directory_uri() . '/images/right-sidebar.png'
    ),
    'left-sidebar' => array(
        'value'     => 'left_sidebar',
        'thumbnail' => get_template_directory_uri() . '/images/left-sidebar.png'
    ),
    'no-sidebar' => array(
        'value'     => 'no_sidebar',
        'thumbnail' => get_template_directory_uri() . '/images/no-sidebar.png'
    )

);

function THEMENAME_sidebar_layout_callback()
{
    global $post , $THEMENAME_sidebar_layout;
    wp_nonce_field( basename( __FILE__ ), 'THEMENAME_sidebar_layout_nonce' );
    ?>

    <table class="form-table page-meta-box">
        <tr>
            <td colspan="4"><?php esc_html_e( 'Choose Sidebar Template', 'THEMENAME' ); ?></td>
        </tr>

        <tr>
            <td>
                <?php
                foreach ($THEMENAME_sidebar_layout as $field) {
                    $THEMENAME_sidebar_metalayout = get_post_meta( $post->ID, 'THEMENAME_sidebar_layout', true );
                    if(!$THEMENAME_sidebar_metalayout){
                        $THEMENAME_sidebar_metalayout = 'right_sidebar';
                    }
                    ?>

                    <div style="float:left; margin-right:30px;">
                        <label>
                            <input id="<?php echo esc_attr($field['value']); ?>" type="radio" name="THEMENAME_sidebar_layout" value="<?php echo esc_attr($field['value']); ?>" <?php checked($field['value'], $THEMENAME_sidebar_metalayout ); ?>/>
                        
                            <img src="<?php echo esc_url( $field['thumbnail'] ); ?>" />
                        </label>
                    </div>
                <?php } // end foreach
                ?>
                <div class="clear"></div>
            </td>
        </tr>
    </table>

<?php }

/**
 * save the custom metabox data
 * @hooked to save_post hook
 */
function THEMENAME_save_sidebar_layout( $post_id ) {
    global $THEMENAME_sidebar_layout, $post;

    // Verify the nonce before proceeding.
    if ( !isset( $_POST[ 'THEMENAME_sidebar_layout_nonce' ] ) || !wp_verify_nonce( sanitize_text_field(wp_unslash($_POST[ 'THEMENAME_sidebar_layout_nonce' ])), basename( __FILE__ ) ) )
        return;

    // Stop WP from clearing custom fields on autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE)
        return;

    if ( isset( $_POST['post_type'] ) && 'page' == sanitize_text_field( wp_unslash( $_POST['post_type'] ) ) ) {
        if (!current_user_can( 'edit_page', $post_id ) )
            return $post_id;
    } elseif (!current_user_can( 'edit_post', $post_id ) ) {
        return $post_id;
    }


    foreach ($THEMENAME_sidebar_layout as $field) {
        //Execute this saving function
        $old = get_post_meta( $post_id, 'THEMENAME_sidebar_layout', true);
        $new = isset( $_POST['THEMENAME_sidebar_layout'] ) ? sanitize_text_field( wp_unslash( $_POST['THEMENAME_sidebar_layout'] ) ) : '';
        if ($new && $new != $old) {
            update_post_meta($post_id, 'THEMENAME_sidebar_layout', $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id,'THEMENAME_sidebar_layout', $old);
        }
    } // end foreach

}
add_action('save_post', 'THEMENAME_save_sidebar_layout');
