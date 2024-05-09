<!-- Mengatur tampilan pagination -->
<?php
if ($data['totalHalaman'] > 1) {
	if ($data['totalHalaman'] > 5) {
		$limitPage = 5;
	} else {
		$limitPage = $data['totalHalaman'];
	}

	if ($data['currPage'] <= 3) {
		$startPage = 1;
		$endPage = $limitPage;
	} elseif ($data['currPage'] > 3 && $data['currPage'] < $data['totalHalaman'] - 2) {
		$startPage = $data['currPage'] - 2;
		$endPage = $data['currPage'] + 2;
	} elseif ($data['currPage'] >= $data['totalHalaman'] - 2) {
		$startPage = $data['totalHalaman'] - $limitPage + 1;
		$endPage = $data['totalHalaman'];
	}
}

// Starting Point
$numStart = $data['numStart'];
$numEnd = $numStart + count($data['peminjaman']) - 1;
?>
<!-- End -->

<main class="bg-gray mx-4">
	<h3>Semua Peminjaman</h3>
	<div class="wrapper bg-light p-4 my-4">
		<?php if ($data['level'] != 3) : ?>
			<button type="button" class="p-2 bg-success text-light border-radius-1 cursor-pointer">
				<i class="fas fa-plus"></i>
				<span>Tambah Peminjaman</span>
			</button>
			<hr class="mt-2">
		<?php endif; ?>

		<div class="d-flex gap-2 justify-content-between align-items-center <?= ($data['level'] != 3) ? 'pt-2' : '';  ?>" id="top-table">
			<select name="entries" id="entries" class="p-2 border-radius-1">
				<option value="7">7</option>
				<option value="15">15</option>
				<option value="30">30</option>
				<option value="-1">Semua Data</option>
			</select>
			<input type="text" class="p-2 border-radius-1" name="search" id="search" placeholder="Cari..." value="<?= isset($_SESSION['search_all']) ? $_SESSION['search_all'] : '' ?>">
		</div>

		<div id="result">
			<div class="d-flex flex-column pt-2">
				<!-- Table Start -->
				<div class="table-wrapper">
					<table>
						<thead>
							<tr>
								<?php if ($data['level'] != 3) : ?>
									<th class="text-center"><input type="checkbox" name="select-all" id="select-all"></th>
								<?php endif; ?>
								<th>Nama Kegiatan</th>
								<th>Pengaju</th>
								<th>Dibuat</th>
								<th>Diperlukan</th>
								<th>Ruang</th>
								<th>Waktu</th>
								<th>Status</th>
								<th colspan="2">Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php if ($data['totalRows'] == 0) : ?>
								<tr>
									<td colspan="10" class="text-center">Data tidak ditemukan</td>
								</tr>
							<?php endif; ?>
							<?php foreach ($data['peminjaman'] as $peminjaman) : ?>
								<tr>
									<?php if ($data['level'] != 3) : ?>
										<td class="text-center"><input class="checkbox" type="checkbox" name="<?= $peminjaman['id'] ?>"></td>
									<?php endif; ?>
									<td></td>
									<td><?= $peminjaman['unit'] ?></td>
									<td><?= $peminjaman['dibuat_tanggal'] ?></td>
									<td><?= $peminjaman['diperlukan_tanggal'] ?></td>
									<td><?= $peminjaman['ruang'] ?></td>
									<td><?= $peminjaman['waktu_mulai'] ?></td>
									<td><?= $peminjaman['status'] ?></td>
									<td class="text-center">
										<a href="user/detail-peminjaman/<?= $peminjaman['id'] ?>" class="text-decoration-none text-primary">
											<i class="fas fa-eye"></i>
										</a>
									</td>
									<td class="text-center">
										<a href="user/detail-peminjaman/<?= $peminjaman['id'] ?>" class="text-decoration-none text-primary">
											<i class="fas fa-trash"></i>
										</a>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<!-- Table End -->

				<!-- Bottom Table Start -->
				<div class="d-flex justify-content-between align-items-center mt-4" id="bottom-table">
					<?php if ($numStart != 0) : ?>
						<?= "Menampilkan $numStart - $numEnd dari $data[totalRows] data"; ?>

						<!-- Paginate Button Start -->
						<ul class="d-flex flex-wrap row-gap-5 list-style-none" id="paginate">
							<?php if ($data['totalHalaman'] != 5 && $data['currPage'] > 3) : ?>
								<li><a class="p-2 text-decoration-none bg-gray" href="user/all_peminjaman/1">&lt;&lt;</a></li>
								<li><a class="p-2 text-decoration-none bg-gray" href="user/all_peminjaman/<?= $data['currPage'] - 1 ?>">&lt;</a></li>
							<?php endif; ?>

							<?php if ($data['totalHalaman'] > 1) : ?>
								<?php for ($i = $startPage; $i <= $endPage; $i++) : ?>
									<li>
										<a class="p-2 text-decoration-none <?= $data['currPage'] == $i ? 'curr-page' : 'bg-gray'; ?>" href="user/all_peminjaman/<?= $i ?>"><?= $i ?></a>
									</li>
								<?php endfor; ?>
							<?php endif; ?>

							<?php if ($data['totalHalaman'] != 5 && $data['currPage'] < $data['totalHalaman'] - 2) : ?>
								<li><a class="p-2 text-decoration-none bg-gray" href="user/all_peminjaman/<?= $data['currPage'] + 1; ?>">&gt;</a></li>
								<li><a class="p-2 text-decoration-none bg-gray" href="user/all_peminjaman/<?= $data['totalHalaman'] ?>">&gt;&gt;</a></li>
							<?php endif; ?>
						</ul>
						<!-- Paginate Button End -->
					<?php endif; ?>
				</div>
				<!-- Bottom Table End -->
			</div>
		</div>
	</div>
</main>