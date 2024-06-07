<!-- Sidebar Start -->
<aside class="px-4 shadow text-light">
	<div class="">
		<h1 class="sidebar-brand py-4 text-center">Sipinrang STIS</h1>
	</div>
	<ul class="sidebar-list list-style-none cursor-pointer">
		<li class="d-flex align-items-center p-5px border-radius-1 mb-2 <?= ($data['title'] == 'Dashboard') ? 'active' : ''; ?>">
			<a href="user">
				<i class="fas fa-home mr-2"></i>
				<a href="user" class="w-full">Beranda</a>
			</a>
		</li>
		<li class="d-flex align-items-center p-5px border-radius-1 mb-2 <?= ($data['title'] == 'Tambah Peminjaman') ? 'active' : ''; ?>">
			<a href="user/tambah-peminjaman">
				<i class="fas fa-plus mr-2"></i>
				<a href="user/tambah-peminjaman" class="w-full">Tambah Peminjaman</a>
			</a>
		</li>
		<?php if ($data['level'] != 2) : ?>
			<li class="d-flex align-items-center p-5px border-radius-1 mb-2 <?= ($data['title'] == 'Daftar Pengguna') ? 'active' : ''; ?>">
				<a href="user/daftar-pengguna">
					<i class="fas fa-list mr-2"></i>
					<a href="user/daftar-pengguna" class="w-full">Daftar Pengguna</a>
				</a>
			</li>
		<?php endif; ?>
		<li class="d-flex align-items-center p-5px border-radius-1 mb-2 <?= ($data['title'] == 'Semua Peminjaman') ? 'active' : ''; ?>">
			<a href="user/all-peminjaman">
				<i class="fas fa-list mr-2"></i>
				<a href="user/all-peminjaman" class="w-full">Semua Peminjaman</a>
			</a>
		</li>
		<li class="d-flex align-items-center p-5px border-radius-1 mb-2 <?= ($data['title'] == 'Peminjaman Saya') ? 'active' : ''; ?>">
			<a href="user/my-peminjaman">
				<i class="fas fa-list mr-2"></i>
				<a href="user/my-peminjaman" class="w-full">Peminjaman Saya</a>
			</a>
		</li>
	</ul>
</aside>
<!-- Sidebar End -->