<!-- Navbar Start -->
<nav class="d-flex justify-content-between align-items-center shadow px-4 py-2 z-1000 bg-gradient-primary">
	<div class="d-flex align-items-center">
		<img src="img/logo.png" alt="Logo STIS" width="35">
		<span class="nav-brand">Sipinrang</span>
	</div>
	<ul class="d-flex gap-2 list-style-none" id="nav-menu">
		<li class="nav-link py-1"><a class="px-4 py-2 scroll-link" href="#home">Beranda</a></li>
		<li class="nav-link py-1"><a class="px-4 py-2 scroll-link" href="#about">Tentang Kami</a></li>
		<li class="nav-link py-1"><a class="px-4 py-2 scroll-link" href="#faq">FAQ</a></li>
		<li class="nav-link py-1"><a class="px-4 py-2 scroll-link" href="#services">Layanan</a></li>
		<li class="nav-link py-1">
			<?php if (!isset($_SESSION['user'])) : ?>
				<a class="px-4 py-2" href="/login">
					<i class="fas fa-arrow-right-to-bracket"></i>
					Login
				</a>
			<?php else : ?>
				<a class="px-4 py-2" href="/user/logout">
					Logout
					<i class="fas fa-arrow-right-from-bracket"></i>
				</a>
			<?php endif; ?>
		</li>
	</ul>
	<span class="z-1000 fs-3" id="mobile-nav"><i class="fas fa-bars-staggered"></i></span>
</nav>
<!-- Nav End -->