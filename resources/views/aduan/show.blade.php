<x-app-layout>
<div class="px-6 py-6 max-w-3xl">

{{-- Tajuk halaman --}}
<h2 class="text-xl font-bold mb-4">Maklumat Aduan</h2>

{{-- Maklumat asas aduan --}}
<p><b>Aset:</b> {{ $aduan->asset->nama }}</p>
<p><b>Pengadu:</b> {{ $aduan->user->name }}</p>
<p><b>Keterangan:</b> {{ $aduan->keterangan }}</p>

{{-- Kemas kini status aduan --}}
<form method="POST" 
    action="{{ route('ict.aduan.update', $aduan) }}" 
    class="mt-6">
    @csrf
    @method('PUT')

    {{-- Status aduan --}}
    <label>Status</label>
    <select name="status" class="w-full border rounded mb-3">
        <option value="baru">Baru</option>
        <option value="dalam_tindakan">Dalam Tindakan</option>
        <option value="selesai">Selesai</option>
    </select>

    {{-- Catatan ICT --}}
    <label>Catatan ICT</label>
    <textarea name="catatan_ict"
        class="w-full border rounded">{{ $aduan->catatan_ict }}</textarea>

    {{-- Simpan perubahan --}}
    <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">
        Simpan
    </button>
    </form>

</div>
</x-app-layout>
