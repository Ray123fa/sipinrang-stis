<?= $kode_status = $data['peminjaman']['status']; ?>

<main>
	<h2>Detail Peminjaman</h2>

	<section class="mt-4" id="detail-peminjaman">
		<form class="box shadow bg-light" action="user/do-edit-peminjaman/<?= $data['peminjaman']['id_pinjam'] ?>" method="POST" style="max-width:40rem">
			<?php Flasher::flash("detail-peminjaman") ?>

			<table>
				<tr>
					<td><label>ID Pinjam</label></td>
					<td>
						<label class="mb-1">ID Pinjam</label>
						<input class="form-input" type="text" value="<?= $data['peminjaman']['id_pinjam'] ?>" readonly>
					</td>
				</tr>
				<tr>
					<td><label for="kegiatan">Kegiatan</label></td>
					<td>
						<label class="mb-1" for="kegiatan">Kegiatan</label>
						<input autocomplete="off" class="form-input" type="text" name="kegiatan" id="kegiatan" value="<?= $data['peminjaman']['kegiatan'] ?>" disabled required>
					</td>
				</tr>
				<tr>
					<td><label for="dresscode">Dresscode</label></td>
					<td>
						<label class="mb-1" for="dresscode">Dresscode</label>
						<input autocomplete="off" class="form-input" type="text" name="dresscode" id="dresscode" value="<?= $data['peminjaman']['dresscode'] ?>" disabled required>
					</td>
				</tr>
				<tr>
					<td><label for="diperlukan_tanggal">Tanggal<br>Diperlukan</label></td>
					<td>
						<label for="diperlukan_tanggal">Tanggal Diperlukan</label>
						<input class="form-input" type="date" name="diperlukan_tanggal" id="diperlukan_tanggal" value="<?= $data['peminjaman']['diperlukan_tanggal'] ?>" min="<?php echo (date('Y-m-d') <= $data['peminjaman']['diperlukan_tanggal']) ? date('Y-m-d') : $data['peminjaman']['diperlukan_tanggal']; ?>" disabled required>
					</td>
				</tr>
				<tr>
					<td><label for="sesi">Sesi</label></td>
					<td>
						<label for="sesi">Sesi</label>
						<select class="form-input" name="sesi" id="sesi" required disabled>
							<?php foreach ($data['list-sesi'] as $sesi) : ?>
								<option value="<?= $sesi['kodeSesi'] ?>" <?= ($data['peminjaman']['sesi'] == $sesi['kodeSesi']) ? 'selected' : '' ?>><?= $sesi['namaSesi'] ?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<tr>
					<td><label for="ruang">Ruang</label></td>
					<td>
						<label class="mb-1" for="ruang">Ruang</label>
						<select class="form-input" name="ruang" id="ruang" required disabled>
							<option value="<?= $data['peminjaman']['ruang'] ?>"><?= $data['peminjaman']['ruang'] ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<td><label for="status">Status</label></td>
					<td>
						<label class="mb-1" for="status">Status</label>
						<select class="form-input" name="status" id="status" required disabled>
							<?php if ($data['level'] == 1) : ?>
								<?php foreach ($data['list-status'] as $status) : ?>
									<option value="<?= $status['kode'] ?>" <?= ($kode_status == $status['kode']) ? 'selected' : '' ?>><?= $status['status'] ?></option>
								<?php endforeach ?>
							<?php elseif ($data['level'] > 1) : ?>
								<option value="<?= $kode_status ?>" selected>
									<?= $data['list-status'][$kode_status - 1]['status']; ?>
								</option>
							<?php endif; ?>
						</select>
					</td>
				</tr>
				<tr>
					<td><label for="keterangan">Keterangan</label></td>
					<td>
						<label class="mb-1" for="keterangan">Keterangan</label>
						<textarea class="form-input" name="keterangan" id="keterangan" style="resize: vertical;" maxlength="255" disabled><?= $data['peminjaman']['keterangan'] ?></textarea>
					</td>
				</tr>
			</table>

			<?php $canEdit = (($kode_status == 1 && $data['unit'] == $data['peminjaman']['unit']) || ($data['level'] == 1)); ?>
			<?php if ($canEdit) : ?>
				<span class="text-right">
					<button class="btn btn-secondary mt-2" type="button" name="edit" id="edit">Edit</button>
					<button class="btn btn-primary mt-2" type="submit" name="simpan" id="simpan" style="cursor: not-allowed;" disabled>Simpan</button>
				</span>
			<?php endif; ?>
		</form>
	</section>
</main>