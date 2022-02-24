<?php
/**
 * Title.
 *
 * Renders post title on archives.
 *
 * @package THEMENAME
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

?>

<h3 class="entry-title" itemprop="headline">
	<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
</h3>
