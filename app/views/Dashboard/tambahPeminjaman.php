<main>
	<h2>Tambah Peminjaman</h2>

	<div class="mt-4" id="tambah-peminjaman">
		<form class="box shadow bg-light" action="peminjaman/tambah" method="POST" style="max-width:40rem">
			<?php Flasher::flash("tambah-peminjaman") ?>

			<table>
				<tr>
					<td><label for="kegiatan">Kegiatan</label></td>
					<td>
						<label class="mb-1" for="kegiatan">Kegiatan</label>
						<input autocomplete="off" class="form-input" type="text" name="kegiatan" id="kegiatan" placeholder="Isi kegiatan" required>
					</td>
				</tr>
				<tr>
					<td><label for="dresscode">Pakaian</label></td>
					<td>
						<label class="mb-1" for="dresscode">Pakaian</label>
						<input autocomplete="off" class="form-input" type="text" name="dresscode" id="dresscode" placeholder="Isi dresscode" required>
					</td>
				</tr>
				<tr>
					<td><label for="diperlukan_tanggal">Tanggal<br>Diperlukan</label></td>
					<td>
						<label for="diperlukan_tanggal">Tanggal Diperlukan</label>
						<input class="form-input" type="date" name="diperlukan_tanggal" id="diperlukan_tanggal" required>
					</td>
				</tr>
				<tr>
					<td><label for="sesi">Sesi</label></td>
					<td>
						<label for="sesi">Sesi</label>
						<select class="form-input" name="sesi" id="sesi" required disabled>
							<option value="" selected>Pilih Sesi</option>
							<option value="1">Sesi 1 (08.00 - 10.00)</option>
							<option value="2">Sesi 2 (10.00 - 12.00)</option>
							<option value="3">Sesi 3 (12.00 - 14.00)</option>
							<option value="4">Sesi 4 (14.00 - 16.00)</option>
							<option value="5">Sesi 5 (16.00 - 18.00)</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><label for="ruang">Ruang</label></td>
					<td>
						<label for="ruang">Ruang</label>
						<select class="form-input" name="ruang" id="ruang" required disabled>
							<option value="" selected>Pilih Ruang</option>
						</select>
					</td>
				</tr>
			</table>

			<span class="text-right">
				<button class="btn btn-secondary mt-2" type="button" name="reset" id="reset">Reset</button>
				<button class="btn btn-primary mt-2" type="submit" name="tambah">Simpan</button>
			</span>
		</form>
	</div>
</main>