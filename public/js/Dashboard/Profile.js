const profile_img = document.getElementById("profile_img");
profile_img.addEventListener("change", function () {
  const file = this.files[0];

  // Jika ukuran file lebih dari 2MB
  if (file.size > 2*1024*1024) {
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
