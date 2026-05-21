## Workflow Pengembangan (Daily Routine)

1. lakukan git pull agar kode sinkron dengan yang ada di github

2. **Start:** Pindah atau buat branch fitur sesuai dengan tiket jira.
    
2. **Coding:** Lakukan perubahan kode.
    
3. **Compile Aset:** Selalu jalankan `npm run dev` untuk memantau perubahan UI.
    
4. **Commit:** Lakukan commit secara berkala dengan Issue Key.
    
5. **Push:** Kirim perubahan ke GitHub.
	
6. **Pull Request (PR):** Buat PR di GitHub untuk digabungkan ke `main`. Anggota tim lain akan melakukan review.
### Format Pesan Commit:
`[Tipe Commit]: [deskripsi singkat]`

- **Tipe Commit:**
    - **feat**: Fitur baru untuk pengguna.
	- **fix**: Memperbaiki bug.
	- **docs**: Perubahan pada dokumentasi saja.
	- **style**: Perubahan tampilan/format kode (bukan logika, misal: _white-space_, titik koma).
	- **refactor**: Mengubah kode tapi tidak menambah fitur atau memperbaiki bug.
	- **test**: Menambah atau memperbaiki unit test.
	- **chore**: Tugas rutin seperti update _dependencies_ atau konfigurasi _build tool_. 
	
- **Tips Menulis Subject**
	- **Gunakan kalimat perintah (imperative):** Gunakan "add" bukan "added", "change" bukan "changed".
	- **Jangan gunakan titik di akhir kalimat.**
	- **Singkat dan jelas:** Usahakan di bawah 50 karakter.
	- **Huruf kecil di awal:** Biasanya dimulai dengan huruf kecil setelah tanda titik dua.
	
- Contoh Implementasi:
	**Bagus (Good):**
	- `feat: add login functionality with Google`
	- `fix: resolve memory leak in dashboard chart`
	- `docs: update installation steps in README`
	**Buruk (Bad):**
	- `fix: perbaiki error` (Terlalu umum)
	- `tambah fitur baru` (Tidak ada tipe dan tidak deskriptif)
	- `update` (Sangat tidak berguna saat _trace back_)
