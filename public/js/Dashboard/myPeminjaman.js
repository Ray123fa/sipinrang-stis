const allSelect = document.getElementById("select-all");
const checkboxes = document.querySelectorAll(".checkbox");
allSelect.addEventListener("click", () => {
  if (allSelect.checked) {
    const text = "Tindakan ini akan memilih semua data yang ada di halaman ini. Lanjutkan?";
    if (confirm(text) === true) {
      checkboxes.forEach((checkbox) => {
        checkbox.checked = true;
      });
    } else {
      allSelect.checked = false;
    }
  } else {
    checkboxes.forEach((checkbox) => {
      checkbox.checked = false;
    });
  }
});

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
      window.history.pushState({}, null, `user/my_peminjaman/1`);
    }
  };
  xhr.open("POST", `user/my_peminjaman`, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(`limit=${entries.value}`);
});

const search = document.getElementById("search");
search.addEventListener("keyup", () => {
  console.log("my");
  const xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      const result = document.getElementById("result");
      result.innerHTML = xhr.responseText;
      window.history.pushState({}, null, `user/my_peminjaman/1`);
    }
  };

  const data = new URLSearchParams();
  data.append("limit", entries.value);
  data.append("search", search.value);

  xhr.open("POST", `search/my_peminjaman`, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(data);
});
