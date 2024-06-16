const entries = document.getElementById("entries");

const optionEntries = document.querySelectorAll(".option-entries");
if (sessionStorage.getItem("limitUser")) {
  optionEntries.forEach((opt) => {
    if (opt.value == sessionStorage.getItem("limitUser")) {
      opt.selected = true;
    }
  });
}
entries.addEventListener("change", () => {
  sessionStorage.setItem("limitUser", entries.value);

  const xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      const result = document.getElementById("result");
      result.innerHTML = xhr.responseText;
      window.history.pushState({}, null, `dashboard/daftar-pengguna/1`);
    }
  };
  xhr.open("POST", `dashboard/daftar-pengguna`, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(`limit-user=${entries.value}`);
});

const search = document.getElementById("search");
search.addEventListener("keyup", () => {
  const xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      const result = document.getElementById("result");
      result.innerHTML = xhr.responseText;
      window.history.pushState({}, null, `dashboard/daftar-pengguna/1`);
    }
  };

  const data = new URLSearchParams();
  data.append("limit-user", entries.value);
  data.append("search", search.value);

  xhr.open("POST", `api/search-user`, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(data);
});

function updateLevel(id, level) {
  const xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      window.location.reload();
    }
  };
  xhr.open("GET", `api/update-level-user/${id}/${level}`, true);
  xhr.send();
}

function deleteUser(level, id) {
  if (level < 3) {
    alert("Superadmin dan admin tidak bisa dihapus!");
    return;
  }

  const res = confirm("Apakah anda yakin ingin menghapus pengguna ini? \nPerhatian: Semua data yang berkaitan dengan pengguna ini akan ikut terhapus!");
  if (res) {
    window.location.href = `user/delete/${id}`;
  } else {
    return;
  }
}
