<form method="POST" action="login/do">
	<input type="text" name="username" id="username" placeholder="Username" class="form-input my-1" maxlength="50" autocomplete="on" value="<?= $data['username'] ?>" required>
	<input type="password" name="pass" id="pass" placeholder="Password" class="form-input my-1" autocomplete="on" minlength="8" value="<?= $data['password'] ?>" required>

	<div class="d-flex gap-2 my-2">
		<input type="checkbox" name="remember-me" id="remember-me" class="cursor-pointer" <?= $data['remember'] ?>>
		<label for="remember-me" class="cursor-pointer text-small">Ingat saya</label>
	</div>

	<button type="submit" name="login" class="my-2 mt-4 btn btn-primary">Login</button>
	<div class="d-flex justify-content-center text-small fw-bold mt-2 flex-column">
		<span class="text-center">Belum punya akun? <a class="text-primary text-decoration-none cursor-pointer" href="login/guest">Login sebagai tamu</a></span>
	</div>
</form>