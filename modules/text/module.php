<?php
/**
 * Text module.
 *
 * @package Milos
 * @subpackage Chriss
 */

/**
 * Generates HTML for Text module.
 *
 * @param  array $config Configuration of the module.
 * @return string HTML of the module
 */
function generate_text_module( $config ) {

	$config_defaults = array(
		'data'   => array(),
		'module' => array(),
	);

	$config = wp_parse_args( $config, $config_defaults );

	$data_defaults = array(
		'vertical_text' => '',
		'image'         => null,
		'image_alt'     => '',
		'sidebar_items' => array(),
		'content_items' => array(),

	);

	$data = wp_parse_args( $config['data'], $data_defaults );

	$left_column_classes = array(
		'col-xs-12',
		'left-content',
		'col-md-3',
	);

	$right_column_classes = array(
		'col-xs-12',
		'right-content',
	);

	if ( ! $data['image'] ) :
		$left_column_classes[]  = 'col-md-offset-1';
		$right_column_classes[] = 'col-md-8';
	else :
		$right_column_classes[] = 'col-md-7';
		$right_column_classes[] = 'col-md-offset-1';
	endif;

	if ( ! $data['image'] && empty( $data['sidebar_items'] ) ) :
		$left_column_classes[] = 'hidden-mobile';
	endif;

	ob_start();
	?>
	<div class="row">
		<?php if ( $data['vertical_text'] ) : ?>
		<span class="vertical-text"><?php echo esc_html( $data['vertical_text'] ); ?></span>
		<?php endif; ?>

		<div <?php the_css_class( $left_column_classes ); ?>>
			<?php if ( $data['image'] ) : ?>
			<div><?php super_img( image: $data['image'], alt: $data['image_alt'], css_class: 'portrait' ); ?></div>
			<?php elseif ( ! empty( $data['sidebar_items'] ) ) : ?>
			<div>
				<?php foreach ( $data['sidebar_items'] as $item ) : ?>
				<div class="title-block">
					<h2 class="heading-03"><?php echo esc_html( $item['title'] ); ?></h2>
					<ul>
						<?php foreach ( $item['links'] as $link ) : ?>
						<li>
							<?php if ( ! $link['url'] ) : ?>
							<div><?php the_link_label( $link ); ?></div>
							<?php else : ?>
							<a <?php the_link_href( $link ); ?>><?php the_link_label( $link ); ?></a>
							<?php endif; ?>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</div>

		<div <?php the_css_class( $right_column_classes ); ?>>
			<?php foreach ( $data['content_items'] as $item ) : ?>
			<div>
				<?php if ( 'text' === $item['type'] ) : ?>
				<div class="item-block" >
					<?php
					if ( $item['title'] ) :
						$title_classes = array(
							'heading-03',
							$item['title_size'] . '-size',
						);
						?>
					<h2 <?php the_css_class( $title_classes ); ?>><?php echo esc_html( $item['title'] ); ?></h2>
					<?php endif; ?>
					<?php
					if ( $item['text'] ) :
						$text_classes = array(
							'text',
							$item['text_size'] . '-size',
						);
						?>
					<div <?php the_css_class( $text_classes ); ?>><?php echo $item['text']; ?></div>
					<?php endif; ?>
				</div>
				<?php elseif ( 'links' === $item['type'] ) : ?>
				<div class="item-block-list">
					<ul>
						<?php foreach ( $item['links'] as $link ) : ?>
						<li>
							<a <?php the_link_href( $link ); ?> <?php the_link_target( $link ); ?>>
								<span><?php the_link_label( $link ); ?></span>
							</a>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<?php endif; ?>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php

	$html = ob_get_clean();

	$args = array(
		'name'  => 'text',
		'html'  => $html,
		'fluid' => true,
	);

	$args = array_merge( $args, $config['module'] );

	ob_start();

	get_template_part( slug: 'template-parts/module', args: $args );

	return ob_get_clean();
}
