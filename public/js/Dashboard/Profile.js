const profile_img = document.getElementById("profile_img");
profile_img.addEventListener("change", function () {
  const file = this.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function () {
      const result = reader.result;
      document.getElementById("profile_img_preview").src = result;
    };
    reader.readAsDataURL(file);
  }
});
