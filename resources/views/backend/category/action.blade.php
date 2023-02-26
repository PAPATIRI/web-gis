<a href="{{ route('category.edit', $model) }}" class="btn btn-warning btn-sm">Edit</a>
<button href="{{ route('category.destroy', $model) }}" class="btn btn-danger btn-sm" id="delete">Hapus</button>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // proses delete akan di jalankan ketika button tersebut di klik 
    // fungsi onclick javascript akan menjalankan event prevent default agar ketika 
    // button di klik tidak melakukan refresh halaman atau memuat halaman baru
    $('button#delete').on('click', function(e) {
        e.preventDefault();

        // selanjutnya mendefinisikan variabel href yang akan memanggil fungsi sweetalert2
        // yaitu Swal.fire dimana dalam funsgi tersebut bisa ditambahkan beberapa opsi seperti
        // source code dibawah
        var href = $(this).attr('href');

        Swal.fire({
            title: 'Hapus Data Ini?',
            text: "Perhatian data yang sudah di hapus tidak bisa di kembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal!'
        }).then((result) => {
            if (result.isConfirmed) {

                // selanjutnya jika user memilih button konfirmasi hapus data
                // ganti event action dengan href dari button delete diatas berdasarkan element dengan Id
                // 'deleteForm' pada form yang ada di halaman index category yang sudah kita tambahkan sebelumnya

                document.getElementById('deleteForm').action = href;
                document.getElementById('deleteForm').submit();

                // Jika berhasil di submit maka akan muncul pesan berikut setelah data terhapus
                Swal.fire(
                    'Terhapus!',
                    'Data sudah terhapus.',
                    'success'
                )
            }
        })
    });
</script>
