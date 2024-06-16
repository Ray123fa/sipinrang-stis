const entries = document.getElementById("entries");
const filterStatus = document.getElementById("filter-status");

function sendLimitStatus() {
  sessionStorage.setItem("entries-semua-peminjaman", entries.value);
  sessionStorage.setItem("filterStatus-semua-peminjaman", filterStatus.value);

  const xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      const result = document.getElementById("result");
      result.innerHTML = xhr.responseText;
      window.history.pushState({}, null, `dashboard/semua-peminjaman/1`);
    }
  };
  xhr.open("POST", `dashboard/semua-peminjaman`, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(`limit-all=${entries.value}&status-all=${filterStatus.value}`);
}

const optionEntries = document.querySelectorAll(".option-entries");
if (sessionStorage.getItem("entries-semua-peminjaman")) {
  optionEntries.forEach((opt) => {
    if (opt.value == sessionStorage.getItem("entries-semua-peminjaman")) {
      opt.selected = true;
    }
  });
}
entries.addEventListener("change", sendLimitStatus);

const optionFilterStatus = document.querySelectorAll(".option-filter-status");
if (sessionStorage.getItem("filterStatus-semua-peminjaman")) {
  optionFilterStatus.forEach((opt) => {
    if (opt.value == sessionStorage.getItem("filterStatus-semua-peminjaman")) {
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
      window.history.pushState({}, null, `dashboard/semua-peminjaman/1`);
    }
  };

  const data = new URLSearchParams();
  data.append("limit", entries.value);
  data.append("status", filterStatus.value);
  data.append("search", search.value);

  xhr.open("POST", `api/search-semua-peminjaman`, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(data);
});

function deletePeminjaman(idpinjam) {
  const confirmation = confirm("Apakah anda yakin ingin menghapus data ini?");
  confirmation ? (window.location.href = `peminjaman/delete/${idpinjam}`) : null;
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
