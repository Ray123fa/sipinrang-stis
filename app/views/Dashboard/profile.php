<?php
if ($data['no_wa'] == null) {
	Flasher::setFlash("Mohon lengkapi/perbarui profil Anda terlebih dahulu", "warning", "profile");
}
?>

<main>
	<h2>Profil Anda</h2>

	<section class="mt-4" id="profile-information">
		<form class="box shadow bg-light" action="user/edit-profile" method="POST" enctype="multipart/form-data">
			<h3>Informasi Profil</h3>
			<p>Section untuk mengubah profil pengguna</p>
			<hr class="my-1">

			<?php Flasher::flash('profile'); ?>

			<input type="hidden" name="id" value="<?= $data['id'] ?>">
			<div class="text-center my-2">
				<label for="profile_img" class="cursor-pointer w-fit-content">
					<img class="rounded-circle" src="<?php
																						if ($data['profile_img_path'] == null) {
																							echo 'img/profile.png';
																						} else if (file_exists($data['profile_img_path'])) {
																							echo $data['profile_img_path'];
																						} else {
																							echo 'img/profile.png';
																						}
																						?>" alt="Foto Profil" width="70" height="70" id="profile_img_preview">
					<span style="margin-left: -10px"><i class="bg-gray fas fa-camera p-1 rounded-circle" style="color: var(--primary-2); width:1rem; height:1rem;"></i></span>
					<input type="file" class="d-none" name="profile_img" id="profile_img" accept="image/*">
				</label>
			</div>
			<table>
				<tr>
					<td><label for="username">Username</label></td>
					<td>
						<label class="mb-1" for="username">Username</label>
						<input autocomplete="off" class="form-input" type="text" name="username" id="username" value="<?= $data['username'] ?>" required>
					</td>
				</tr>
				<tr>
					<td><label for="no_wa">No. WhatsApp</label></td>
					<td>
						<label class="mb-1" for="no_wa">No. WhatsApp</label>
						<input autocomplete="off" class="form-input" type="tel" placeholder="+6281234567890" pattern="^\+62[0-9]{9,13}$" name="no_wa" id="no_wa" value="<?= $data['no_wa'] ?>" required>
						<small>Format: +62 diikuti oleh 9-13 digit angka</small>
					</td>
				</tr>
				<tr>
					<td><label for="unit">Unit</label></td>
					<td>
						<label class="mb-1" for="unit">Unit</label>
						<input autocomplete="off" class="form-input" type="text" name="unit" id="unit" value="<?= $data['unit'] ?>" disabled>
					</td>
				</tr>
				<tr>
					<td><label for="level">Level</label></td>
					<td>
						<label class="mb-1" for="level">Level</label>
						<input autocomplete="off" class="form-input" type="text" name="level" id="level" value="<?= $data['level'] ?>" disabled>
					</td>
				</tr>
			</table>

			<span class="text-right">
				<button class="btn btn-primary mt-2" type="submit" name="edit">Simpan</button>
			</span>
		</form>
	</section>

	<section class="my-6" id="change-password">
		<div class="box shadow bg-light">
			<h3>Perbarui Password</h3>
			<p>Section untuk memperbarui password</p>
			<hr class="my-1">

			<?php Flasher::flash('change-password'); ?>

			<form class="d-flex flex-column" action="user/change-password" method="POST">
				<input autocomplete="off" class="form-input my-1" type="password" name="old-pass" id="old-pass" placeholder="Password Lama" minlength="8" required>
				<input autocomplete="off" class="form-input my-1" type="password" name="new-pass" id="new-pass" placeholder="Password Baru" minlength="8" required>
				<input autocomplete="off" class="form-input my-1" type="password" name="renew-pass" id="renew-pass" placeholder="Konfirmasi Password Baru" minlength="8" required>

				<span class="text-right">
					<button class="btn btn-primary mt-2" type="submit" name="change">Simpan</button>
				</span>
			</form>
		</div>
	</section>
</main>