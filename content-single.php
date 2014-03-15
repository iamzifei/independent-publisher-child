<?php
/**
 * @package Independent Publisher
 * @since   Independent Publisher 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
	<header class="entry-header">
		<h2 class="entry-title-meta">
      <span class="entry-title-meta-author">
        <?php if ( ! independent_publisher_categorized_blog() ) {
			echo independent_publisher_entry_meta_author_prefix() . ' ';
		}
		independent_publisher_posted_author() ?></span>
			<?php if ( independent_publisher_categorized_blog() ) {
				echo independent_publisher_entry_meta_category_prefix() . ' ' . independent_publisher_post_categories( '', true );
			} ?>
			<span class="entry-title-meta-post-date">
        <span class="sep"> <?php echo apply_filters( 'independent_publisher_entry_meta_separator', '|' ); ?> </span>
				<?php independent_publisher_posted_on_date() ?>
      </span>
			<?php do_action( 'independent_publisher_entry_title_meta', $separator = ' | ' ); ?>
		</h2>

		<h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
	</header>
	<!-- .entry-header -->

	<div class="entry-content" itemprop="mainContentOfPage">

		<?php if ( in_category( 'Journal' ) ) : ?>

			<?php raamdev_the_content() ?>

		<?php else : ?>

			<?php the_content(); ?>

		<?php endif; ?>

		<?php wp_link_pages(
			array(
				'before'           => '<div class="page-links-next-prev">',
				'after'            => '</div>',
				'nextpagelink'     => '<button class="next-page-nav">' . __( 'Next page &rarr;', 'independent_publisher' ) . '</button>',
				'previouspagelink' => '<button class="previous-page-nav">' . __( '&larr; Previous page', 'independent_publisher' ) . '</button>',
				'next_or_number'   => 'next'
			)
		); ?>
		<?php wp_link_pages(
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'independent_publisher' ),
				'after'  => '</div>'
			)
		); ?>
	</div>
	<!-- .entry-content -->

	<?php independent_publisher_posted_author_bottom_card() ?>

	<footer class="entry-meta">
		<?php do_action( 'independent_publisher_entry_meta_top' ); ?>

		<?php if ( comments_open() && ! independent_publisher_hide_comments() ) : ?>
			<div id="share-comment-button">
				<button>
					<i class="share-comment-icon"></i><?php echo independent_publisher_comments_call_to_action_text() ?>
				</button>
			</div>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'independent_publisher' ), '<span class="edit-link">', '</span>' ); ?>
	</footer>
	<!-- .entry-meta -->

</article><!-- #post-<?php the_ID(); ?> -->