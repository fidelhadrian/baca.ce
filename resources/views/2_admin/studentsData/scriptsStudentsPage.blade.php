<script>
    function confirmDelete(nim) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data mahasiswa ini akan dihapus permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            reverseButtons: true,
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika pengguna mengonfirmasi, kirimkan form penghapusan
                document.getElementById('delete-form-' + nim).submit();
            }
        });
    }
</script>


<script>
    document.getElementById('select-all').addEventListener('click', function(e) {
        const checkboxes = document.querySelectorAll('.student-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = e.target.checked;
        });
        toggleDeleteButton();
    });

    document.querySelectorAll('.student-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', toggleDeleteButton);
    });

    function toggleDeleteButton() {
        const selectedCheckboxes = document.querySelectorAll('.student-checkbox:checked');
        const deleteButton = document.getElementById('delete-selected-btn');
        deleteButton.style.display = selectedCheckboxes.length > 0 ? 'inline-block' : 'none';
    }

    // Ketika tombol hapus dipilih
    document.getElementById('delete-selected-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const selectedCheckboxes = document.querySelectorAll('.student-checkbox:checked');
        const studentIds = Array.from(selectedCheckboxes).map(checkbox => checkbox.value);

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data mahasiswa yang dipilih akan dipindahkan ke sampah!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirimkan ID yang dipilih ke server
                const form = document.getElementById('delete-selected-form');
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'students';
                input.value = JSON.stringify(studentIds);
                form.appendChild(input);
                form.submit();
            }
        });
    });
</script>
