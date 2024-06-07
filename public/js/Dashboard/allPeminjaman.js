const entries = document.getElementById("entries");
const filterStatus = document.getElementById("filter-status");

function sendLimitStatus() {
  sessionStorage.setItem("entries", entries.value);
  sessionStorage.setItem("filterStatus", filterStatus.value);

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
  xhr.send(`limit=${entries.value}&status=${filterStatus.value}`);
}

const optionEntries = document.querySelectorAll(".option-entries");
if (sessionStorage.getItem("entries")) {
  optionEntries.forEach((opt) => {
    if (opt.value == sessionStorage.getItem("entries")) {
      opt.selected = true;
    }
  });
}
entries.addEventListener("change", sendLimitStatus);

const optionFilterStatus = document.querySelectorAll(".option-filter-status");
if (sessionStorage.getItem("filterStatus")) {
  optionFilterStatus.forEach((opt) => {
    if (opt.value == sessionStorage.getItem("filterStatus")) {
      opt.selected = true;
    }
  });
}
filterStatus.addEventListener("change", sendLimitStatus);

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
  data.append("status", filterStatus.value);
  data.append("search", search.value);

  xhr.open("POST", `api/search-all-peminjaman`, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(data);
});

function deletePeminjaman(idpinjam) {
  const confirmation = confirm("Apakah anda yakin ingin menghapus data ini?");
  confirmation ? (window.location.href = `user/do-delete-peminjaman/${idpinjam}`) : null;
}

function updateStatus(id, status) {
  const xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      window.location.reload();
    }
  };
  xhr.open("GET", `api/update-status-peminjaman/${id}/${status}`, true);
  xhr.send();
}
