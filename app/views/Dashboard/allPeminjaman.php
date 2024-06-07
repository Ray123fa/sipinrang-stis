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

<main class="mx-4">
	<h3 class="mb-4">Semua Peminjaman</h3>
	<?php Flasher::flash("all-peminjaman") ?>

	<div class="wrapper bg-light p-4 my-4">
		<div class="d-flex gap-2 justify-content-between align-items-center py-2" id="top-table">
			<div class="d-flex justify-content-start gap-2" id="filtered">
				<select name="entries" id="entries" class="p-2 border-radius-1">
					<option value="7" class="option-entries">7</option>
					<option value="15" class="option-entries">15</option>
					<option value="30" class="option-entries">30</option>
					<option value="-1" class="option-entries">Semua</option>
				</select>
				<select name="filter-status" id="filter-status" class="p-2 border-radius-1">
					<option value="-1" class="option-filter-status">Semua Status</option>
					<option value="1" class="option-filter-status">Dalam Persetujuan BAU</option>
					<option value="2" class="option-filter-status">Disetujui</option>
					<option value="3" class="option-filter-status">Ditolak</option>
				</select>
			</div>
			<input type="text" class="p-2 border-radius-1" name="search" id="search" placeholder="Cari..." value="<?= isset($_SESSION['search_all']) ? $_SESSION['search_all'] : '' ?>">
		</div>

		<div id="result">
			<div class="d-flex flex-column pt-2">
				<!-- Table Start -->
				<div class="table-wrapper">
					<table>
						<thead>
							<tr>
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
									<td colspan="9" class="text-center">Data tidak ditemukan</td>
								</tr>
							<?php endif; ?>
							<?php foreach ($data['peminjaman'] as $peminjaman) : ?>
								<tr>
									<td><?= $peminjaman['kegiatan'] ?></td>
									<td class="text-center"><?= $peminjaman['unit'] ?></td>
									<td class="text-center"><?= $peminjaman['dibuat_tanggal'] ?></td>
									<td class="text-center"><?= $peminjaman['diperlukan_tanggal'] ?></td>
									<td class="text-center"><?= $peminjaman['ruang'] ?></td>
									<td class="text-center">
										<?= $data['list-sesi'][(string) $peminjaman['sesi'] - 1]['namaSesi'] ?>
									</td>
									<td class="text-center">
										<select name="post-status" class="p-2 border-radius-1" onchange="updateStatus('<?= $peminjaman['id_pinjam'] ?>', this.value)" <?= $data['level'] != 1 ? 'disabled' : '' ?>>
											<option value="1" class="option-post-status" <?= ($peminjaman['status'] == 1) ? 'selected' : '' ?>>Proses Persetujuan BAU</option>
											<option value="2" class="option-post-status" <?= ($peminjaman['status'] == 2) ? 'selected' : '' ?>>Disetujui</option>
											<option value="3" class="option-post-status" <?= ($peminjaman['status'] == 3) ? 'selected' : '' ?>>Ditolak</option>
										</select>
									</td>
									<td class="text-center">
										<a href="user/detail-peminjaman/<?= $peminjaman['id_pinjam'] ?>" class="text-decoration-none text-primary px-1">
											<i class="fas fa-eye"></i>
										</a>
									</td>
									<?php if ($data['level'] != 2) : ?>
										<td class="text-center">
											<a class="text-decoration-none text-primary px-1 cursor-pointer" onclick="deletePeminjaman('<?= $peminjaman['id_pinjam'] ?>')">
												<i class="fas fa-trash"></i>
											</a>
										</td>
									<?php endif; ?>
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
								<li><a class="p-2 text-decoration-none bg-gray" href="user/all-peminjaman/1">&lt;&lt;</a></li>
								<li><a class="p-2 text-decoration-none bg-gray" href="user/all-peminjaman/<?= $data['currPage'] - 1 ?>">&lt;</a></li>
							<?php endif; ?>

							<?php if ($data['totalHalaman'] > 1) : ?>
								<?php for ($i = $startPage; $i <= $endPage; $i++) : ?>
									<li>
										<a class="p-2 text-decoration-none <?= $data['currPage'] == $i ? 'curr-page' : 'bg-gray'; ?>" href="user/all-peminjaman/<?= $i ?>"><?= $i ?></a>
									</li>
								<?php endfor; ?>
							<?php endif; ?>

							<?php if ($data['totalHalaman'] != 5 && $data['currPage'] < $data['totalHalaman'] - 2) : ?>
								<li><a class="p-2 text-decoration-none bg-gray" href="user/all-peminjaman/<?= $data['currPage'] + 1; ?>">&gt;</a></li>
								<li><a class="p-2 text-decoration-none bg-gray" href="user/all-peminjaman/<?= $data['totalHalaman'] ?>">&gt;&gt;</a></li>
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