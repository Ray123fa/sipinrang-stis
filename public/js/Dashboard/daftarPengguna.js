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
      window.history.pushState({}, null, `user/daftar-pengguna/1`);
    }
  };
  xhr.open("POST", `user/daftar-pengguna`, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(`limit-user=${entries.value}`);
});

const search = document.getElementById("search");
search.addEventListener("keyup", () => {
  const xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      const result = document.getElementById("result");
      console.log(xhr.responseText);
      result.innerHTML = xhr.responseText;
      window.history.pushState({}, null, `user/daftar-pengguna/1`);
    }
  };

  const data = new URLSearchParams();
  data.append("limit-user", entries.value);
  data.append("search", search.value);

  xhr.open("POST", `api/search-user`, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.send(data);
});
