<!-- Sidebar Start -->
<aside class="px-4 shadow text-light">
	<div class="">
		<h1 class="sidebar-brand py-4 text-center">Sipinrang STIS</h1>
	</div>
	<ul class="sidebar-list list-style-none cursor-pointer">
		<li class="d-flex align-items-center p-5px border-radius-1 mb-2 <?= ($data['title'] == 'Dashboard') ? 'active' : ''; ?>">
			<i class="fas fa-home mr-2"></i>
			<a href="user">Beranda</a>
		</li>
		<li class="d-flex align-items-center p-5px border-radius-1 mb-2 <?= ($data['title'] == 'Semua Peminjaman') ? 'active' : ''; ?>">
			<i class="fas fa-list mr-2"></i>
			<a href="user/all_peminjaman">Semua Peminjaman</a>
		</li>
		<li class="d-flex align-items-center p-5px border-radius-1 mb-2 <?= ($data['title'] == 'Peminjaman Saya') ? 'active' : ''; ?>">
			<i class="fas fa-list mr-2"></i>
			<a href="user/my_peminjaman">Peminjaman Saya</a>
		</li>
		<li class="p-5px border-radius-1 mb-2">woi</li>
		<li class="p-5px border-radius-1 mb-2">woi</li>
	</ul>
</aside>
<!-- Sidebar End -->