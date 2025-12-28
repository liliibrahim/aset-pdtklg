<x-app-layout>
    <div class="max-w-xl mx-auto py-6">
        
        {{-- Tajuk halaman --}}
        <h2 class="text-xl font-bold mb-4">Aduan Kerosakan Aset</h2>

        {{-- Borang aduan kerosakan --}}
        <form id="form-aduan"
              method="POST"
              action="{{ route('user.aduan.store') }}">
            @csrf

            {{-- ID aset --}}
            <input type="hidden" name="asset_id" value="{{ $asset->id }}">

            {{-- Maklumat aset (paparan sahaja) --}}
            <div class="mb-4 p-4 border rounded bg-gray-50">
                <h3 class="font-semibold mb-3 text-gray-700">
                    Maklumat Aset Dilaporkan
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-600">Kategori</label>
                        <input type="text" value="{{ $asset->kategori }}"
                               class="w-full border rounded px-3 py-2 bg-gray-100"
                               readonly>
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Jenama</label>
                        <input type="text" value="{{ $asset->jenama }}"
                               class="w-full border rounded px-3 py-2 bg-gray-100"
                               readonly>
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Model</label>
                        <input type="text" value="{{ $asset->model }}"
                               class="w-full border rounded px-3 py-2 bg-gray-100"
                               readonly>
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">No Siri</label>
                        <input type="text" value="{{ $asset->no_siri }}"
                               class="w-full border rounded px-3 py-2 bg-gray-100"
                               readonly>
                    </div>
                </div>
            </div>

            {{-- Pilih jenis aduan --}}
            <div class="mb-3">
                <label class="text-sm font-medium">Jenis Aduan</label>
                <select name="jenis_aduan"
                        class="w-full border rounded px-3 py-2"
                        required>
                    <option value="">-- Pilih --</option>
                    <option value="Rosak">Rosak</option>
                    <option value="Tidak Berfungsi">Tidak Berfungsi</option>
                    <option value="Prestasi Perlahan">Prestasi Perlahan</option>
                </select>
            </div>

            {{-- Keterangan aduan --}}
            <div class="mb-4">
                <label class="text-sm font-medium">Keterangan Aduan</label>
                <textarea name="keterangan"
                          rows="4"
                          class="w-full border rounded px-3 py-2"
                          placeholder="Nyatakan masalah yang dihadapi"
                          required></textarea>
            </div>

            {{-- Hantar aduan --}}
            <button type="button"
                    id="btn-hantar-aduan"
                    class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 disabled:opacity-60">
                Hantar Aduan
            </button>

        </form>
    </div>

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const btnHantar = document.getElementById('btn-hantar-aduan');
            const formAduan = document.getElementById('form-aduan');

            btnHantar.addEventListener('click', function () {

                // Sahkan aduan
                Swal.fire({
                    title: 'Sahkan Aduan Kerosakan',
                    text: 'Adakah anda pasti ingin menghantar aduan bagi aset ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hantar Aduan',
                    cancelButtonText: 'Batal'
                }).then((result) => {

                    if (result.isConfirmed) {

                        // Elak hantar dua kali
                        btnHantar.disabled = true;
                        btnHantar.innerText = 'Sedang dihantar...';

                        // Hantar borang
                        formAduan.submit();

                        // Kembali ke dashboard
                        setTimeout(() => {
                            window.location.href = "{{ route('user.dashboard') }}";
                        }, 800);
                    }
                });
            });
        });
    </script>
</x-app-layout>
