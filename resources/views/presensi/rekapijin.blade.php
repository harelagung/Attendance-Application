@extends('layouts.presensirekapijin')

@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="{{ route('dashboard') }}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Data Ijin Karyawan</div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
    <div class="row" style="margin-top:65px">
        <div class="col">
            @php
                $messagesuccess = Session::get('success');
                $messageerror = Session::get('error');
            @endphp
            @if ($messagesuccess)
                <div class="alert alert-success">
                    {{ $messagesuccess }}
                </div>
            @endif
            @if ($messageerror)
                <div class="alert alert-danger">
                    {{ $messageerror }}
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col">
            @forelse ($datarekap as $d)
                @if ($d->status === 'Ijin')
                    <ul class="listview image-listview" style="margin-top: 3px">
                        <li class="show-detail" data-id_formulir="{{ $d->id_formulir }}"
                            data-alasan_penolakan="{{ $d->alasan_penolakan }}" data-tgl_formulir="{{ $d->tgl_formulir }}"
                            data-status="{{ $d->status }}" data-status-approved="{{ $d->status_approved }}"
                            data-tgl_ijin="{{ $d->tgl_ijin }}" data-jam_mulai="{{ $d->jam_mulai }}"
                            data-jam_selesai="{{ $d->jam_selesai }}" data-alasan_ijin="{{ $d->alasan_ijin }}"
                            data-keterangan="{{ $d->keterangan }}" data-bukti="{{ $d->bukti }}"
                            data-bukti-url="{{ $d->bukti ? asset('storage/upload/bukti/' . $d->bukti) : '' }}">
                            <div class="item">
                                <div class="in">
                                    <div>
                                        <b>{{ date('d-m-Y', strtotime($d->tgl_ijin)) }}</b><br>
                                        <small class="text-muted">{{ $d->alasan_ijin }}</small>
                                    </div>
                                    @if ($d->status_approved == 0)
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif ($d->status_approved == 1)
                                        <span class="badge bg-success">Disetujui</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </div>
                            </div>
                        </li>
                    </ul>
                @endif
            @empty
                <center><span style="font-weight:700"><br><br><br><br><br><br><br><br><br><br><br>Belum ada data ijin</span>
                </center>
            @endforelse
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered"> {{-- modal vertically centered --}}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center fs-3" style="font-weight: 700; font-size:1rem"
                        id="detailModalLabel">Detail Pengajuan Ijin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- Akan di-populate oleh JS --}}
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-warning" id="editButton" style="align-content: center">Edit</a>
                    <form method="POST" action="" id="deleteForm" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger" id="btnDelete">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bukti Foto Modal -->
    <div class="modal fade" id="buktiModal" tabindex="-1" aria-labelledby="buktiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center" style="font-weight: 700; font-size:1rem" id="buktiModalLabel">
                        Bukti Foto</h5>
                </div>
                <div class="modal-body text-center">
                    <img id="bukti-image" src="" class="img-fluid" alt="Bukti Foto">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnCloseBuktiModal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        function handleBack() {
            window.history.back();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const modalEl = document.getElementById('detailModal');
            const bsModal = new bootstrap.Modal(modalEl);
            const body = modalEl.querySelector('.modal-body');
            const editButton = document.getElementById('editButton');
            const deleteForm = document.getElementById('deleteForm');
            const btnDelete = document.getElementById('btnDelete');

            btnDelete.addEventListener('click', (e) => {
                e.preventDefault(); // mencegah default form submit

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: 'Data yang dihapus tidak dapat dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteForm.submit();
                    }
                });
            });

            // Modal bukti foto
            const buktiModalEl = document.getElementById('buktiModal');
            const bsBuktiModal = new bootstrap.Modal(buktiModalEl);
            const btnCloseBukti = document.getElementById('btnCloseBuktiModal');
            const buktiImage = document.getElementById('bukti-image');

            // bind tombol tutup untuk modal bukti
            btnCloseBukti.addEventListener('click', () => bsBuktiModal.hide());

            document.querySelectorAll('.show-detail').forEach(el => {
                el.addEventListener('click', () => {
                    const d = el.dataset;

                    const id_formulir = d.id_formulir || d.idFormulir || d.id || 'TIDAK_ADA';
                    console.log('ID yang akan digunakan:', id_formulir);

                    let html = '';
                    html +=
                        `<p><strong>Tanggal Formulir:</strong> ${formatDate(d.tgl_formulir)}</p>`;
                    html += `<p><strong>Status:</strong> ${d.status}</p>`;

                    if (d.status === 'Cuti') {
                        html += `<p><strong>Tgl. Mulai:</strong> ${formatDate(d.tgl_mulai)}</p>`;
                        html +=
                            `<p><strong>Tgl. Selesai:</strong> ${formatDate(d.tgl_selesai)}</p>`;
                        html += `<p><strong>Jenis Cuti:</strong> ${d.jenis_cuti}</p>`;
                    } else if (d.status === 'Ijin') {
                        html += `<p><strong>Tgl. Ijin:</strong> ${formatDate(d.tgl_ijin)}</p>`;
                        html += `<p><strong>Jam Mulai:</strong> ${d.jam_mulai}</p>`;
                        html += `<p><strong>Jam Selesai:</strong> ${d.jam_selesai}</p>`;
                        html += `<p><strong>Alasan Ijin:</strong> ${d.alasan_ijin}</p>`;
                    }

                    html += `<p><strong>Keterangan:</strong> ${d.keterangan}</p>`;

                    // Modified: Tampilkan link bukti dengan event listener untuk modal
                    if (d.bukti) {
                        html +=
                            `<p><strong>Bukti:</strong> <a href="#" class="lihat-bukti" data-bukti-url="${d.buktiUrl}">Lihat</a></p>`;
                    } else {
                        html += `<p><strong>Bukti:</strong> -</p>`;
                    }

                    // baca status-approved sesuai nilai asli
                    html +=
                        `<p><strong>Status:</strong> ${statusApprovedText(d.statusApproved || d.statusApproved === '0' ? d.statusApproved : d.statusApproved)}</p>`;

                    // Tampilkan alasan penolakan hanya jika status = 2 (Ditolak)
                    if (d.statusApproved === '2') {
                        html +=
                            `<p><strong>Alasan Penolakan:</strong> ${d.alasan_penolakan}</p>`;
                    }

                    body.innerHTML = html;

                    // Tambahkan event listener untuk link "Lihat" bukti
                    const lihatBuktiLink = body.querySelector('.lihat-bukti');
                    if (lihatBuktiLink) {
                        lihatBuktiLink.addEventListener('click', function(e) {
                            e.preventDefault();
                            const buktiUrl = this.getAttribute('data-bukti-url');
                            buktiImage.src = buktiUrl;
                            bsBuktiModal.show();
                        });
                    }

                    // Set URL untuk button Edit
                    const editUrl = `/formulir/editijin/${d.id_formulir}`;
                    editButton.href = editUrl;

                    // Set URL untuk button Delete
                    deleteForm.action = `/formulir/deleteijin/${d.id_formulir}`;

                    // Menampilkan Edit dan Hapus berdasarkan status
                    const approvedStatus = parseInt(d.statusApproved);
                    if (approvedStatus === 0 || approvedStatus === 2) {
                        editButton.style.display = 'inline-block';
                        deleteForm.style.display = 'inline-block';
                    } else {
                        editButton.style.display = 'none';
                        deleteForm.style.display = 'none';
                    }
                    console.log('Menampilkan modal...');
                    bsModal.show();
                });
            });

            function formatDate(raw) {
                const dt = new Date(raw);
                return dt.toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                });
            }

            function statusApprovedText(code) {
                if (code === '0') return 'Pending';
                if (code === '1') return 'Disetujui';
                return 'Ditolak';
            }
        });
    </script>
@endpush
