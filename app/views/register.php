<form method="POST" action="register/do">
	<input class="form-input my-1" type="text" name="username" id="username" placeholder="Username" oninput="this.style.textTransform = 'lowercase'" maxlength="50" required>

	<input class="form-input my-1" type="email" name="email" id="email" placeholder="Email STIS" maxlength="50" required>

	<input class="form-input my-1" type="text" name="unit" id="unit" placeholder="Organisasi/Unit/UKM/Himada" oninput="this.style.textTransform = 'uppercase'" required>

	<input class="form-input my-1" type="password" name="pass" id="pass" placeholder="Password" autocomplete="on" minlength="8" required>
	<input class="form-input my-1" type="password" name="repass" id="repass" placeholder="Konfirmasi Password" autocomplete="on" minlength="8" required>

	<input type="hidden" name="level" id="level" value="3">

	<button type="submit" name="register" class="my-2 btn btn-primary">Register</button>
	<div class="d-flex justify-content-center text-small fw-bold mt-2">
		<span class="text-center">Sudah mempunyai akun? <a href="login" class="text-primary text-decoration-none">Login sekarang!</a></span>
	</div>
</form>