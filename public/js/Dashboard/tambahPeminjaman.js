const tglPerlu = document.getElementById("diperlukan_tanggal");
const today = new Date();
const todayFormatted = `${today.getFullYear()}-${(today.getMonth() + 1).toString().padStart(2, "0")}-${today.getDate().toString().padStart(2, "0")}`;
tglPerlu.setAttribute("min", todayFormatted);

const sesi = document.getElementById("sesi");
tglPerlu.addEventListener("change", () => {
  sesi.disabled = false;

  if (sesi.value != "") {
    getAvailRuang();
  }
});
sesi.addEventListener("change", () => {
  getAvailRuang();
});

const reset = document.getElementById("reset");
const input = document.querySelectorAll("input");
reset.addEventListener("click", () => {
  input.forEach((item) => {
    item.value = "";
  });
  sesi.disabled = true;
  sesi.value = "";
  ruang.disabled = true;
  ruang.value = "";
});

function getAvailRuang() {
  const ruang = document.getElementById("ruang");
  const xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      const response = JSON.parse(this.responseText);
      ruang.disabled = false;
      ruang.innerHTML = "";

      var option = document.createElement("option");
      option.value = "";
      option.innerHTML = "Pilih Ruang";
      option.selected = true;
      ruang.appendChild(option);

      response.forEach((item) => {
        var option = document.createElement("option");
        option.value = item.ruang;
        option.innerHTML = item.ruang;
        ruang.appendChild(option);
      });
    }
  };

  xhr.open("GET", `api/get-avail-ruang/${tglPerlu.value}/${sesi.value}`, true);
  xhr.send();
}
