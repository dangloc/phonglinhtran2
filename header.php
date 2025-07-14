<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package commicpro
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="google-site-verification" content="la4PZI4ISH6kgrzxE1SMgiZ9y8QzHLfFtlBi2gobYug" />

	<?php wp_head(); ?>

	 <!-- <script>
		document.addEventListener('DOMContentLoaded', function() {
			// Prevent text selection
			document.addEventListener('selectstart', function(e) {
				e.preventDefault();
			});
			
			// Prevent copy
			document.addEventListener('copy', function(e) {
				e.preventDefault();
				// Add watermark to clipboard if copy is attempted
				const watermark = '\n\n--- Bản quyền © ' + new Date().getFullYear() + ' ' + document.title + ' ---\n';
				e.clipboardData.setData('text/plain', watermark);
			});
			
			// Prevent cut
			document.addEventListener('cut', function(e) {
				e.preventDefault();
			});
			
			// Prevent right-click
			document.addEventListener('contextmenu', function(e) {
				e.preventDefault();
			});

			// Prevent drag
			document.addEventListener('dragstart', function(e) {
				e.preventDefault();
			});

			// Prevent keyboard shortcuts
			document.addEventListener('keydown', function(e) {
				// Prevent Ctrl+C, Ctrl+X, Ctrl+A, Ctrl+U (view source)
				if ((e.ctrlKey || e.metaKey) && (e.key === 'c' || e.key === 'x' || e.key === 'a' || e.key === 'u')) {
					e.preventDefault();
				}
				// Prevent F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+Shift+C
				if (e.key === 'F12' || 
					(e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J' || e.key === 'C'))) {
					e.preventDefault();
				}
			});

			// Add CSS to prevent text selection and add watermark
			const style = document.createElement('style');
			style.textContent = `
				* {
					-webkit-user-select: none !important;
					-moz-user-select: none !important;
					-ms-user-select: none !important;
					user-select: none !important;
				}
				.entry-content {
					-webkit-user-select: text !important;
					-moz-user-select: text !important;
					-ms-user-select: text !important;
					user-select: text !important;
					position: relative;
				}
				.entry-content::before {
					content: '';
					position: fixed;
					top: 0;
					left: 0;
					width: 100%;
					height: 100%;
					pointer-events: none;
					background: linear-gradient(45deg, 
						rgba(255,255,255,0) 0%,
						rgba(255,255,255,0.1) 25%,
						rgba(255,255,255,0) 50%,
						rgba(255,255,255,0.1) 75%,
						rgba(255,255,255,0) 100%);
					z-index: 9999;
				}
				.entry-content::after {
					content: '${document.title}';
					position: fixed;
					top: 50%;
					left: 50%;
					transform: translate(-50%, -50%) rotate(-45deg);
					font-size: 24px;
					color: rgba(0,0,0,0.1);
					pointer-events: none;
					white-space: nowrap;
					z-index: 9999;
				}
			`;
			document.head.appendChild(style);

			// Disable DevTools
			(function() {
				function detectDevTools() {
					const widthThreshold = window.outerWidth - window.innerWidth > 160;
					const heightThreshold = window.outerHeight - window.innerHeight > 160;
					if (widthThreshold || heightThreshold) {
						document.body.innerHTML = 'DevTools không được phép sử dụng trên trang này.';
					}
				}
				window.addEventListener('resize', detectDevTools);
				setInterval(detectDevTools, 1000);
			})();

			// Disable console
			(function() {
				const methods = ['log', 'debug', 'info', 'warn', 'error', 'assert', 'dir', 'dirxml', 'group', 'groupEnd', 'time', 'timeEnd', 'count', 'trace', 'profile', 'profileEnd'];
				methods.forEach(method => {
					console[method] = function() {};
				});
			})();
		});
	</script> -->
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'commicpro' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding container">
			<div class="site-branding-left">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<?php $logo_url = get_field('logo_url', 2); ?>
					<img src="<?php echo $logo_url['url']; ?>" alt="logo">
				</a>
			</div>
			<div class="site-branding-mid w-100">
				<div class="search-form-container d-flex align-items-center w-100">
					<form role="search" method="get" class="d-flex" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<input type="search" class="form-control search-input" placeholder="Tìm kiếm..." value="<?php echo get_search_query(); ?>" name="s" aria-label="Search">
					</form>
				</div>
			</div>
			<div class="site-branding-right">
				<?php
				if ( is_user_logged_in() ) :
					$current_user = wp_get_current_user();
					?>
					<div class="user-info dropdown">
						<!-- Trigger dropdown on hover -->
						<div class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
								<?php echo get_avatar( $current_user->ID, 32 ); ?>
								<span class="mx-2 name-user"><?php echo esc_html( $current_user->user_login ); ?></span>
						</div>

						<!-- Dropdown menu -->
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="<?php echo esc_url( get_author_posts_url( $current_user->ID ) ); ?>">Thông tin tài khoản</a></li>
							<li><hr class="dropdown-divider"></li>
							<?php
							wp_nav_menu( array(
								'theme_location' => 'header-menu',
								'container'      => false,
								'items_wrap'     => '%3$s', // chỉ in <li>...</li>
								'walker'         => new Bootstrap_Dropdown_Walker()
							) );
							?>
							<li><hr class="dropdown-divider"></li>
							<li><a class="dropdown-item" href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>">Đăng xuất</a></li>
					</ul>
					</div>
				<?php else : ?>
					<div class="auth-buttons d-none d-md-flex">
						<button class="btn btn-primary me-1" data-bs-toggle="modal" data-bs-target="#loginModal">Đăng nhập</button>
						<button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#registerModal">Đăng ký</button>
					</div>
					<div class="auth-dropdown d-md-none">
						<button class="btn dropdown-toggle" style="color:#fff; border: 1px solid #fff; border-radius: 40px;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="fas fa-user"></i>
						</button>
						<ul class="dropdown-menu dropdown-menu-end">
							<li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#loginModal">Đăng nhập</button></li>
							<li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#registerModal">Đăng ký</button></li>
						</ul>
					</div>
				<?php endif; ?>
			</div>
		</div><!-- .site-branding -->

		<div class="main_menu">
			<nav id="site-navigation" class="main-navigation">
				<!-- <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php //esc_html_e( 'Primary Menu', 'commicpro' ); ?></button> -->
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
					)
				);
				?>
			</nav><!-- #site-navigation -->
		</div>
	</header><!-- #masthead -->

	<!-- Login Modal -->
	<div class="modal fade" id="loginModal" aria-hidden="true" aria-labelledby="loginModalLabel" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5 text-black" id="loginModalLabel">Đăng nhập</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form id="login-form" method="post">
						<div class="mb-3">
							<label for="login-username" class="form-label">Tên đăng nhập</label>
							<input type="text" class="form-control" id="login-username" name="username" required>
						</div>
						<div class="mb-3">
							<label for="login-password" class="form-label">Mật khẩu</label>
							<input type="password" class="form-control" id="login-password" name="password" required>
						</div>
						<div class="mb-3 form-check">
							<input type="checkbox" class="form-check-input" id="remember-me" name="remember">
							<label class="form-check-label" for="remember-me">Ghi nhớ đăng nhập</label>
						</div>
						<div class="d-grid">
							<button type="submit" class="btn btn-primary">Đăng nhập</button>
						</div>
						<div class="text-center mt-2">
							<button type="button" class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal" data-bs-dismiss="modal">
								Quên mật khẩu?
							</button>
						</div>
					</form>
				</div>
				<div class="modal-footer justify-content-center flex-column">
					<div class="d-flex">
						<a class="btn btn-primary" href="https://tusachiep.xyz/wp-login.php?loginSocial=google" data-plugin="nsl" data-action="connect" data-redirect="current" data-provider="google" data-popupwidth="600" data-popupheight="600">
							Đăng nhập bằng google <img style="width: 24px; height: 24px;" src="<?php bloginfo('template_url'); ?>/assets/images/google.svg" alt="">
						</a>
					</div>
					<p class="mb-0 text-black">Chưa có tài khoản? 
						<button class="btn text-black btn-link p-0" data-bs-target="#registerModal" data-bs-toggle="modal" data-bs-dismiss="modal">
							Đăng ký ngay
						</button>
					</p>
				</div>
			</div>
		</div>
	</div>

	<!-- Register Modal -->
	<div class="modal fade" id="registerModal" aria-hidden="true" aria-labelledby="registerModalLabel" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5 text-black" id="registerModalLabel">Đăng ký tài khoản</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form id="register-form" method="post">
						<div class="mb-3">
							<label for="register-username" class="form-label">Tên đăng nhập</label>
							<input type="text" class="form-control" id="register-username" name="username" required>
						</div>
						<div class="mb-3">
							<label for="register-email" class="form-label">Email</label>
							<input type="email" class="form-control" id="register-email" name="email" required>
						</div>
						<div class="mb-3">
							<label for="register-password" class="form-label">Mật khẩu</label>
							<input type="password" class="form-control" id="register-password" name="password" required>
						</div>
						<div class="mb-3">
							<label for="register-password-confirm" class="form-label">Xác nhận mật khẩu</label>
							<input type="password" class="form-control" id="register-password-confirm" name="password_confirm" required>
						</div>
						<div class="d-grid">
							<button type="submit" class="btn btn-primary">Đăng ký</button>
						</div>
					</form>
				</div>
				
				<div class="modal-footer justify-content-center flex-column">
					<div class="d-flex">
						<a class="btn btn-primary" href="https://tusachiep.xyz/wp-login.php?loginSocial=google" data-plugin="nsl" data-action="connect" data-redirect="current" data-provider="google" data-popupwidth="600" data-popupheight="600">
							Đăng nhập bằng google <img style="width: 24px; height: 24px;" src="<?php bloginfo('template_url'); ?>/assets/images/google.svg" alt="">
						</a>
					</div>
					<p class="mb-0 text-black">Đã có tài khoản? 
						<button class="btn text-black btn-link p-0" data-bs-target="#loginModal" data-bs-toggle="modal" data-bs-dismiss="modal">
							Đăng nhập
						</button>
					</p>
				</div>
			</div>
		</div>
	</div>

	<!-- Forgot Password Modal -->
	<div class="modal fade" id="forgotPasswordModal" aria-hidden="true" aria-labelledby="forgotPasswordModalLabel" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5 text-black" id="forgotPasswordModalLabel">Quên mật khẩu</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form id="forgot-password-form" method="post">
						<div class="mb-3">
							<label for="forgot-email" class="form-label">Email</label>
							<input type="email" class="form-control" id="forgot-email" name="email" required>
						</div>
						<div class="d-grid">
							<button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
						</div>
					</form>
				</div>
				<div class="modal-footer justify-content-center flex-column">
					<p class="mb-0 text-black">
						Đã nhớ mật khẩu?
						<button class="btn text-black btn-link p-0" data-bs-target="#loginModal" data-bs-toggle="modal" data-bs-dismiss="modal">
							Đăng nhập
						</button>
					</p>
				</div>
			</div>
		</div>
	</div>

	<script>
	jQuery(document).ready(function($) {
		// Function to convert Vietnamese text to non-accented text
		function removeAccents(str) {
			return str.normalize('NFD')
				.replace(/[\u0300-\u036f]/g, '') // Remove diacritics
				.replace(/đ/g, 'd').replace(/Đ/g, 'D') // Convert đ to d
				.replace(/[^a-zA-Z0-9]/g, ''); // Only allow letters and numbers
		}

		// Add event listener for username input
		$('#register-username').on('input', function() {
			var input = $(this);
			var originalValue = input.val();
			var convertedValue = removeAccents(originalValue);
			input.val(convertedValue);
		});

		// Xử lý form đăng nhập
		$('#login-form').on('submit', function(e) {
			e.preventDefault();
			
			var formData = {
				action: 'ajax_login',
				username: $('#login-username').val(),
				password: $('#login-password').val(),
				remember: $('#remember-me').is(':checked'),
				nonce: '<?php echo wp_create_nonce('ajax_login_nonce'); ?>'
			};

			$.ajax({
				url: '<?php echo admin_url('admin-ajax.php'); ?>',
				type: 'POST',
				data: formData,
				success: function(response) {
					if (response.success) {
						Swal.fire({
							title: 'Thành công!',
							text: 'Đăng nhập thành công',
							icon: 'success',
							confirmButtonText: 'OK'
						}).then((result) => {
							window.location.reload();
						});
					} else {
						Swal.fire({
							title: 'Lỗi!',
							text: response.data,
							icon: 'error',
							confirmButtonText: 'OK'
						});
					}
				}
			});
		});

		// Xử lý form đăng ký
		$('#register-form').on('submit', function(e) {
			e.preventDefault();
			
			var password = $('#register-password').val();
			var passwordConfirm = $('#register-password-confirm').val();

			if (password !== passwordConfirm) {
				Swal.fire({
					title: 'Lỗi!',
					text: 'Mật khẩu xác nhận không khớp',
					icon: 'error',
					confirmButtonText: 'OK'
				});
				return;
			}

			var formData = {
				action: 'ajax_register',
				username: $('#register-username').val(),
				email: $('#register-email').val(),
				password: password,
				nonce: '<?php echo wp_create_nonce('ajax_register_nonce'); ?>'
			};

			$.ajax({
				url: '<?php echo admin_url('admin-ajax.php'); ?>',
				type: 'POST',
				data: formData,
				success: function(response) {
					if (response.success) {
						Swal.fire({
							title: 'Thành công!',
							text: 'Đăng ký thành công. Vui lòng kiểm tra email để xác nhận tài khoản.',
							icon: 'success',
							confirmButtonText: 'OK'
						}).then((result) => {
							// Chuyển sang form đăng nhập
							$('#registerModal').modal('hide');
							$('#loginModal').modal('show');
						});
					} else {
						Swal.fire({
							title: 'Lỗi!',
							text: response.data,
							icon: 'error',
							confirmButtonText: 'OK'
						});
					}
				}
			});
		});

		// Xử lý form quên mật khẩu
		$('#forgot-password-form').on('submit', function(e) {
			e.preventDefault();
			var email = $('#forgot-email').val();
			var formData = {
				action: 'ajax_forgot_password',
				email: email,
				nonce: '<?php echo wp_create_nonce('ajax_forgot_password_nonce'); ?>'
			};
			$.ajax({
				url: '<?php echo admin_url('admin-ajax.php'); ?>',
				type: 'POST',
				data: formData,
				success: function(response) {
					if (response.success) {
						Swal.fire({
							title: 'Thành công!',
							text: 'Vui lòng kiểm tra email để đặt lại mật khẩu.',
							icon: 'success',
							confirmButtonText: 'OK'
						}).then(() => {
							$('#forgotPasswordModal').modal('hide');
						});
					} else {
						Swal.fire({
							title: 'Lỗi!',
							text: response.data,
							icon: 'error',
							confirmButtonText: 'OK'
						});
					}
				}
			});
		});
	});
	</script>

<?php wp_footer(); ?>
</body>
</html>
