const allSelect = document.getElementById("select-all");
const checkboxes = document.querySelectorAll(".checkbox");
const btnHapus = document.getElementById("btn-hapus");

if (allSelect != null) {
  allSelect.addEventListener("click", () => {
    if (allSelect.checked) {
      btnHapus.disabled = false;
      checkboxes.forEach((checkbox) => {
        checkbox.checked = true;
      });
    } else {
      checkboxes.forEach((checkbox) => {
        checkbox.checked = false;
      });
      btnHapus.disabled = true;
    }
  });

  checkboxes.forEach((checkbox) => {
    checkbox.addEventListener("click", () => {
      let count = 0;
      checkboxes.forEach((checkbox) => {
        if (checkbox.checked) {
          count++;
        }
      });

      if (count > 0) {
        btnHapus.disabled = false;
      } else {
        btnHapus.disabled = true;
      }

      if (count == checkboxes.length) {
        allSelect.checked = true;
      } else {
        allSelect.checked = false;
      }
    });
  });
}

const option = document.querySelectorAll("option");
if (sessionStorage.getItem("entries")) {
  option.forEach((opt) => {
    if (opt.value == sessionStorage.getItem("entries")) {
      opt.selected = true;
    }
  });
}
const entries = document.getElementById("entries");
entries.addEventListener("change", () => {
  sessionStorage.setItem("entries", entries.value);
  const xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      const result = document.getElementById("result");
      result.innerHTML = xhr.responseText;
      window.history.pushState({}, null, `user/all-peminjaman/1`);
    }
  };
  xhr.open("POST", `user/all-peminjaman`, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(`limit=${entries.value}`);
});

const search = document.getElementById("search");
search.addEventListener("keyup", () => {
  const xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      const result = document.getElementById("result");
      result.innerHTML = xhr.responseText;
      window.history.pushState({}, null, `user/all-peminjaman/1`);
    }
  };

  const data = new URLSearchParams();
  data.append("limit", entries.value);
  data.append("search", search.value);

  xhr.open("POST", `api/search-all-peminjaman`, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(data);
});
