@extends('2_admin.layouts.base')

@section('title', 'Trashed Students')

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="javascript:history.back()" class="btn btn-secondary mt-3">Kembali</a>
            <h3 class="card-title">Data Mahasiswa yang Terhapus</h3>
        </div>
        <div class="card-body">
            @if ($students->isEmpty())
                <div class="alert alert-info">
                    <i class="icon fas fa-info"></i>
                    Tidak ada data mahasiswa yang terhapus.
                </div>
            @else
                <form action="{{ route('admin.handleSelectedAction') }}" method="POST" id="handle-selected-action-form">
                    @csrf

                    <div class="mb-3">
                        <!-- Pilihan Aksi untuk mahasiswa yang dipilih -->
                        <button type="submit" class="btn btn-success mb-3" name="action" value="restore"
                            id="restore-selected-btn" style="display: none;">Restore yang dipilih</button>
                        <button type="submit" class="btn btn-danger mb-3" name="action" value="forceDelete"
                            id="force-delete-selected-btn" style="display: none;">Hapus Permanen yang dipilih</button>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="select-all-trashed"> </th>
                                <!-- Checkbox untuk memilih semua -->
                                <th>#</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Angkatan</th>
                                <th>Gender</th>
                                <th>Status</th>
                                <th>Deleted At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $index => $student)
                                <tr>
                                    <td><input type="checkbox" class="student-checkbox" name="students[]"
                                            value="{{ $student->nim }}"></td>
                                    <td>{{ $loop->iteration + ($students->currentPage() - 1) * $students->perPage() }}</td>
                                    <td>{{ $student->nim }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->angkatan }}</td>
                                    <td>{{ $student->gender }}</td>
                                    <td>{{ $student->status }}</td>
                                    <td>{{ $student->deleted_at }}</td>
                                    <td>
                                        <!-- Restore -->
                                        <form action="{{ route('admin.restore', $student->nim) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Restore</button>
                                        </form>

                                        <!-- Force Delete -->
                                        <form action="{{ route('admin.forceDelete', $student->nim) }}" method="POST"
                                            style="display:inline-block;" class="force-delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm delete-btn">Force
                                                Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
            @endif
        </div>
        <div class="card-footer clearfix">
            {{ $students->links('pagination::bootstrap-4') }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('select-all-trashed').addEventListener('click', function(e) {
            const checkboxes = document.querySelectorAll('.student-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = e.target.checked;
            });
            toggleActionButtons();
        });

        document.querySelectorAll('.student-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', toggleActionButtons);
        });

        function toggleActionButtons() {
            const selectedCheckboxes = document.querySelectorAll('.student-checkbox:checked');
            const restoreButton = document.getElementById('restore-selected-btn');
            const forceDeleteButton = document.getElementById('force-delete-selected-btn');
            restoreButton.style.display = selectedCheckboxes.length > 0 ? 'inline-block' : 'none';
            forceDeleteButton.style.display = selectedCheckboxes.length > 0 ? 'inline-block' : 'none';
        }

        // SweetAlert konfirmasi untuk Force Delete
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                const form = this.closest('form');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data mahasiswa ini akan dihapus permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
