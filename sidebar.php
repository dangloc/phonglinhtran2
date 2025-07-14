<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package commicpro
 */
?>

<aside id="secondary" class="widget-area">
	

	<div class="sidebar-top-rank">
		<?php
		// Lấy 9 truyện đã hoàn thành
		$truyen_query = new WP_Query([
			 	'post_type' => 'truyen_chu',
                'posts_per_page' => 9,
                'meta_key' => 'rmp_rating_val_sum', // Meta key của plugin Rate My Post
                'orderby' => 'meta_value_num',
                'order' => 'DESC'
		]);

		if ($truyen_query->have_posts()) : ?>
			<section class="section-slider pb-2">
				<div class="section-title"><span>Top đánh giá cao</span></div>
				<div class="swiper swiper-latest-top-sidebar">
					<div class="swiper-wrapper">
						<?php while ($truyen_query->have_posts()) : $truyen_query->the_post(); ?>
							<div class="swiper-slide">
								<a href="<?php the_permalink(); ?>">
									<div class="d-flex sidebar-top-rank-item justify-content-between">
											<div class="img-box">
												<?php 
												$featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
												?>
												<img src="<?php echo $featured_img_url ?>" 
													alt="<?php the_title_attribute(); ?>" 
													onerror="this.src='<?php echo get_template_directory_uri(); ?>/assets/images/icon-book.png'"
												/>
											</div>
											<div class="title-box">
												<div class="slide-title"><?php the_title(); ?></div>
												<div>
													<?php 
													$trang_thai = get_the_terms(get_the_ID(), 'trang_thai');
													$is_completed = false;
													if ($trang_thai && !is_wp_error($trang_thai)) {
														foreach ($trang_thai as $term) {
															if ($term->slug === 'da-hoan-thanh') {
																$is_completed = true;
																break;
															}
														}
													}
													?>
													<p class="count-port">
														<?php
														if($is_completed){
															?>
															Full
															<?php
														}else{
															?>
															<small class="text-muted-custom chapter-count" data-truyen-id="<?php echo get_the_ID(); ?>">
																<?php echo $is_completed ? 'Full' : '...'; ?>
															</small>
															<?php
														}
														?>
													</p>
													<?php
													// Hiển thị thể loại
													$the_loai = get_the_terms(get_the_ID(), 'the_loai');
													if ($the_loai && !is_wp_error($the_loai)) : ?>
														<p class="mb-1">
															<small class="text-muted-custom">
																<?php
																$the_loai_names = array();
																foreach ($the_loai as $term) {
																	$the_loai_names[] = $term->name;
																}
																echo esc_html(implode(', ', $the_loai_names));
																?>
															</small>
														</p>
													<?php endif; ?>
												</div>
											</div>
									</div>
								</a>
							</div>
						<?php endwhile; ?>
					</div>
				</div>
			</section>
		<?php endif; 
		wp_reset_postdata();
		?>
	</div>


	<div class="sidebar-top-new">
		<?php
		// Lấy 9 truyện đã hoàn thành
		$truyen_new_query = new WP_Query([
			'post_type'      => 'truyen_chu',
			'posts_per_page' => 6,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'tax_query'      => [
				[
					'taxonomy' => 'trang_thai',
					'field'    => 'slug',
					'terms'    => 'da-hoan-thanh'
				]
			]
		]);

		if ($truyen_new_query->have_posts()) : ?>
			<section class="py-3">
				<div class="section-title"><span>Truyện full mới nhất</span></div>
				<div class="">
					<div class="row gy-3 mt-3">
						<?php while ($truyen_new_query->have_posts()) : $truyen_new_query->the_post(); ?>
							<div class="col-12">
								<a href="<?php the_permalink(); ?>">
									<div class="d-flex sidebar-top-new-item justify-content-between">
										<div class="img-box">
											<?php 
											$featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
											?>
											<img src="<?php echo $featured_img_url ?>" 
												alt="<?php the_title_attribute(); ?>" 
												onerror="this.src='<?php echo get_template_directory_uri(); ?>/assets/images/icon-book.png'"
											/>
										</div>
										<div class="title-box">
											<div class="slide-title"><?php the_title(); ?></div>
											<div>
												<?php 
												$trang_thai1 = get_the_terms(get_the_ID(), 'trang_thai');
												$is_completed1 = false;
												if ($trang_thai1 && !is_wp_error($trang_thai1)) {
													foreach ($trang_thai1 as $term) {
														if ($term->slug === 'da-hoan-thanh') {
															$is_completed1 = true;
															break;
														}
													}
												}
												?>
												<p class="count-port">
													<?php
													if($is_completed1){
														?>
														Full
														<?php
													}else{
														?>
														<small class="text-muted-custom chapter-count" data-truyen-id="<?php echo get_the_ID(); ?>">
															<?php echo $is_completed1 ? 'Full' : '...'; ?>
														</small>
														<?php
													}
													?>
												</p>
												<?php
												// Hiển thị thể loại
												$the_loai = get_the_terms(get_the_ID(), 'the_loai');
												if ($the_loai && !is_wp_error($the_loai)) : ?>
													<p class="mb-1">
														<small class="text-muted-custom">
															<?php
															$the_loai_names = array();
															foreach ($the_loai as $term) {
																$the_loai_names[] = $term->name;
															}
															echo esc_html(implode(', ', $the_loai_names));
															?>
														</small>
													</p>
												<?php endif; ?>
											</div>
										</div>
									</div>
								</a>
							</div>
						<?php endwhile; ?>
					</div>
				</div>
			</section>
		<?php endif; 
		wp_reset_postdata();
		?>
	</div>
</aside>
