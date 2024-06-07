# Sipinrang STIS

### Deskripsi

Sipinrang merupakan sebuah sistem informasi yang dibuat untuk mempermudah proses peminjaman ruang yang ada di Polstat STIS.

Aplikasi ini juga terintegrasi dengan bot telegram yang dapat mengirimkan notifikasi ke dalam private grup setiap terjadi perubahan pada tabel peminjaman. Selain mengirimkan notifikasi ke dalam grup, bot telegram tersebut juga memberikan layanan untuk cek status peminjaman berdasarkan ID Peminjaman, layanan untuk mengkoneksikan akun telegram dengan akun Sipinrang. Tak hanya itu, bagi yang sudah mengkoneksikannya dengan akun Sipinrang, apabila pihak BAU memberikan update mengenai peminjaman yang diajukan, bot telegram juga akan mengirimkan notifikasi ke akun yang ditautkan.

[![Telegram Bot](https://img.shields.io/badge/Telegram-Bot-blue.svg?style=for-the-badge&logo=telegram)](https://t.me/sipinrang_bot)

### Roles

| Roles   | Deskripsi                                                                                             |
| ------- | ----------------------------------------------------------------------------------------------------- |
| `BAU`   | User yang berfunsi sebagai administrator dan pemberi keputusan apakah peminjaman diterima atau tidak. |
| `Unit`  | User yang dapat mengajukan peminjaman ruangan.                                                        |
| `Guest` | User yang hanya memiliki akses lihat untuk keseluruhan peminjaman.                                    |

### Permissions

| Permission                   | Roles         |
| ---------------------------- | ------------- |
| `CRUD Peminjaman`            | `BAU`, `Unit` |
| `RUD User`                  | `BAU`         |
| `Update Profile`                | `BAU`, `Unit` |
| `Update Status Peminjaman`   | `BAU`         |
| `Read-only Semua Peminjaman` | `Guest`       |

### Views

`Landing Page` : Sebagai halaman awal aplikasi.  
`Login Page` : Sebagai halaman untuk masuk ke dalam sistem berdasar roles/level.  
`Dashboard` : Tampilan setelah berhasil login.

### Built With

Aplikasi ini dibuat dengan menggunakan teknologi:

![HTML5](https://img.shields.io/badge/html5-%23E34F26.svg?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/css3-%231572B6.svg?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/javascript-%23323330.svg?style=for-the-badge&logo=javascript&logoColor=%23F7DF1E)
![PHP](https://img.shields.io/badge/PHP-blue.svg?style=for-the-badge&logo=php&logoColor=white)
