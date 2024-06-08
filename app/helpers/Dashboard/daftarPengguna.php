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
$numEnd = $numStart + count($data['users']) - 1;
?>
<!-- End -->

<div class="d-flex flex-column pt-2">
	<!-- Table Start -->
	<div class="table-wrapper">
		<table>
			<thead>
				<tr>
					<th>Username</th>
					<th>Email</th>
					<th>Unit</th>
					<th>Level</th>
					<th>Chat ID</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($data['totalRows'] == 0) : ?>
					<tr>
						<td colspan="6" class="text-center">Data tidak ditemukan</td>
					</tr>
				<?php endif; ?>
				<?php foreach ($data['users'] as $user) : ?>
					<tr>
						<td><?= $user['username'] ?></td>
						<td class="text-center"><?= $user['email'] ?></td>
						<td class="text-center"><?= $user['unit'] ?></td>
						<td class="text-center"><?= $user['level'] ?></td>
						<td class="text-center"><?= ($user['chat_id'] == '') ? '-' : $user['chat_id'] ?></td>
						<td class="text-center">
							<a class="text-decoration-none text-danger px-1 cursor-pointer" href="#">
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
					<li><a class="p-2 text-decoration-none bg-gray" href="user/daftar-pengguna/1">&lt;&lt;</a></li>
					<li><a class="p-2 text-decoration-none bg-gray" href="user/daftar-pengguna/<?= $data['currPage'] - 1 ?>">&lt;</a></li>
				<?php endif; ?>

				<?php if ($data['totalHalaman'] > 1) : ?>
					<?php for ($i = $startPage; $i <= $endPage; $i++) : ?>
						<li>
							<a class="p-2 text-decoration-none <?= $data['currPage'] == $i ? 'curr-page' : 'bg-gray'; ?>" href="user/daftar-pengguna/<?= $i ?>"><?= $i ?></a>
						</li>
					<?php endfor; ?>
				<?php endif; ?>

				<?php if ($data['totalHalaman'] != 5 && $data['currPage'] < $data['totalHalaman'] - 2) : ?>
					<li><a class="p-2 text-decoration-none bg-gray" href="user/daftar-pengguna/<?= $data['currPage'] + 1; ?>">&gt;</a></li>
					<li><a class="p-2 text-decoration-none bg-gray" href="user/daftar-pengguna/<?= $data['totalHalaman'] ?>">&gt;&gt;</a></li>
				<?php endif; ?>
			</ul>
			<!-- Paginate Button End -->
		<?php endif; ?>
	</div>
	<!-- Bottom Table End -->
</div>