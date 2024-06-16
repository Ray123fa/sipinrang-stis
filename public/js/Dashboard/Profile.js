const profile_img = document.getElementById("profile_img");
profile_img.addEventListener("change", function () {
  const file = this.files[0];

  // Jika ukuran file lebih dari 2MB
  if (file.size > 2 * 1024 * 1024) {
    alert("Ukuran file terlalu besar! Maksimal 2MB.");
    this.value = "";
    return;
  }

  if (file) {
    const reader = new FileReader();
    reader.onload = function () {
      const result = reader.result;
      document.getElementById("profile_img_preview").src = result;
    };
    reader.readAsDataURL(file);
  }
});

const username = document.getElementById("username");
username.addEventListener("keyup", function () {
  const value = this.value;
  if (!/^[a-zA-Z0-9._]+$/.test(value) && value !== "") {
    this.setCustomValidity("Username hanya boleh berisi huruf, angka, titik, dan garis bawah.");
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
