<main>
	<h2>Tambah Pengguna</h2>

	<div class="mt-4" id="tambah-pengguna">
		<form class="box shadow bg-light" action="user/add" method="POST" style="max-width:40rem">
			<?php Flasher::flash("tambah-pengguna") ?>

			<table>
				<tr>
					<td><label for="username">Username <span style="color: red;">*</span></label></td>
					<td>
						<label class="mb-1" for="username">Username <span style="color: red;">*</span></label>
						<input autocomplete="off" class="form-input" type="text" name="username" id="username" placeholder="Isi username" minlength="3" required>
					</td>
				</tr>
				<tr>
					<td><label for="unit">Unit <span style="color: red;">*</span></label></td>
					<td>
						<label class="mb-1" for="unit">Unit <span style="color: red;">*</span></label>
						<input autocomplete="off" class="form-input" type="text" name="unit" id="unit" placeholder="Isi nama organisasi/unit/UKM" onkeyup="this.style.textTransform = 'uppercase'" minlength="3" required>
					</td>
				</tr>
				<tr>
					<td><label for="password">Password <span style="color: red;">*</span></label></td>
					<td>
						<label class="mb-1" for="password">Password <span style="color: red;">*</span></label>
						<input autocomplete="off" class="form-input" type="password" name="password" id="password" placeholder="********" minlength="8" required>
					</td>
				</tr>
				<tr>
					<td><label for="re-password">Re-password <span style="color: red;">*</span></label></td>
					<td>
						<label class="mb-1" for="re-password">Re-password <span style="color: red;">*</span></label>
						<input autocomplete="off" class="form-input" type="password" name="re-password" id="re-password" placeholder="********" minlength="8" required>
					</td>
				</tr>
				<tr>
					<td><label for="no_wa">WhatsApp</label></td>
					<td>
						<label class="mb-1" for="no_wa">WhatsApp</label>
						<input autocomplete="off" class="form-input" type="tel" name="no_wa" id="no_wa" placeholder="+6281234567890" pattern="^\+62[0-9]{9,13}$">
						<small>Format: +62 diikuti oleh 9-13 digit angka</small>
					</td>
				</tr>
				<tr>
					<td><label for="role">Role <span style="color: red;">*</span></label></td>
					<td>
						<label class="mb-1" for="role">Role <span style="color: red;">*</span></label>
						<select class="form-input" name="role" id="role" required>
							<option value="" disabled selected>Select Role</option>
							<option value="1" <?= ($data['level'] < 2) ? '' : 'disabled' ?>>Superadmin</option>
							<option value="2">Admin</option>
							<option value="3">User</option>
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