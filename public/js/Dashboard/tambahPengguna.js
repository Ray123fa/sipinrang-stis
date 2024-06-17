const password = document.getElementById("password");
const repassword = document.getElementById("re-password");
repassword.addEventListener("keyup", function () {
  const value = this.value;

  if (value !== password.value && value !== "") {
    this.setCustomValidity("Password tidak sama!");
  } else {
    this.setCustomValidity("");
  }
});

const nowa = document.getElementById("no_wa");
nowa.addEventListener("keyup", function () {
  const value = this.value;
  if (!/^\+62[0-9]{9,13}$/.test(value) && value !== "") {
    this.setCustomValidity("Format nomor WhatsApp salah!");
  } else {
    this.setCustomValidity("");
  }
});

const reset = document.getElementById("reset");
const input = document.querySelectorAll("input");
const role = document.getElementById("role");
reset.addEventListener("click", () => {
  input.forEach((item) => {
    item.value = "";
  });
  role.value = "";
});
