<!-- Sidebar Start -->
<aside class="px-4 shadow text-light">
	<div class="">
		<h1 class="sidebar-brand py-4 text-center">Sipinrang STIS</h1>
	</div>
	<ul class="sidebar-list list-style-none">
		<li class="cursor-pointer d-flex align-items-center p-5px border-radius-1 mb-2 <?= ($data['title'] == 'Dashboard') ? 'active' : ''; ?>" onclick="window.location.href = 'dashboard'">
			<a href="dashboard">
				<i class="fas fa-home mr-2"></i>
				<a href="dashboard" class="w-full">Beranda</a>
			</a>
		</li>
		<?php if ($data['level'] != 4) : ?>
			<li class="cursor-pointer d-flex align-items-center p-5px border-radius-1 mb-2 <?= ($data['title'] == 'Tambah Peminjaman') ? 'active' : ''; ?>" onclick="window.location.href = 'dashboard/tambah-peminjaman'">
				<a href="dashboard/tambah-peminjaman">
					<i class="fas fa-plus mr-2"></i>
					<a href="dashboard/tambah-peminjaman" class="w-full">Tambah Peminjaman</a>
				</a>
			</li>
		<?php endif; ?>
		<?php if ($data['level'] < 3) : ?>
			<li class="cursor-pointer d-flex align-items-center p-5px border-radius-1 mb-2 <?= ($data['title'] == 'Tambah Pengguna') ? 'active' : ''; ?>" onclick="window.location.href = 'dashboard/tambah-pengguna'">
				<a href="dashboard/tambah-pengguna">
					<i class="fas fa-plus mr-2"></i>
					<a href="dashboard/tambah-pengguna" class="w-full">Tambah Pengguna</a>
				</a>
			</li>
			<li class="cursor-pointer d-flex align-items-center p-5px border-radius-1 mb-2 <?= ($data['title'] == 'Daftar Pengguna') ? 'active' : ''; ?>" onclick="window.location.href = 'dashboard/daftar-pengguna'">
				<a href="dashboard/daftar-pengguna">
					<i class="fas fa-list mr-2"></i>
					<a href="dashboard/daftar-pengguna" class="w-full">Daftar Pengguna</a>
				</a>
			</li>
		<?php endif; ?>
		<li class="cursor-pointer d-flex align-items-center p-5px border-radius-1 mb-2 <?= ($data['title'] == 'Semua Peminjaman') ? 'active' : ''; ?>" onclick="window.location.href = 'dashboard/semua-peminjaman'">
			<a href=" dashboard/semua-peminjaman">
				<i class="fas fa-list mr-2"></i>
				<a href="dashboard/semua-peminjaman" class="w-full">Semua Peminjaman</a>
			</a>
		</li>
		<?php if ($data['level'] != 4) : ?>
			<li class="cursor-pointer d-flex align-items-center p-5px border-radius-1 mb-2 <?= ($data['title'] == 'Riwayat Peminjaman') ? 'active' : ''; ?>" onclick="window.location.href = 'dashboard/riwayat-peminjaman'">
				<a href="dashboard/riwayat-peminjaman">
					<i class="fas fa-list mr-2"></i>
					<a href="dashboard/riwayat-peminjaman" class="w-full">Riwayat Peminjaman</a>
				</a>
			</li>
		<?php endif; ?>
	</ul>
</aside>
<!-- Sidebar End -->