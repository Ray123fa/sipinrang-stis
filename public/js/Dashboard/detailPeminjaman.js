const tglPerlu = document.getElementById("diperlukan_tanggal");
const sesi = document.getElementById("sesi");
const editBtn = document.getElementById("edit");
if (editBtn != null) {
  editBtn.addEventListener("click", () => {
    const disabledInput = document.querySelectorAll("input:disabled");
    const disabledSelect = document.querySelectorAll("select:disabled");
    const disabledTextarea = document.querySelectorAll("textarea:disabled");

    disabledInput.forEach((input) => {
      input.removeAttribute("disabled");
    });
    disabledSelect.forEach((select) => {
      select.removeAttribute("disabled");
    });
    disabledTextarea.forEach((textarea) => {
      textarea.removeAttribute("disabled");
    });

    getAvailRuang();

    const simpanBtn = document.getElementById("simpan");
    simpanBtn.style.cursor = "pointer";
    simpanBtn.removeAttribute("disabled");
  });
}

function getAvailRuang() {
  const ruang = document.getElementById("ruang");
  const xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      const response = JSON.parse(this.responseText);

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

  $("#ruang").select2();
}
