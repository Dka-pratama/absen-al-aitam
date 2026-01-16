@extends('layouts.walikelas')

@section('content')
<div class="p-6 max-w-4xl mx-auto">

    <h1 class="mb-6 text-2xl font-bold">Export Laporan Absensi</h1>

    <form method="GET" class="rounded-xl bg-white p-6 shadow space-y-6">

        {{-- MODE --}}
<select name="mode" id="mode" class="mt-1 w-full rounded border px-3 py-2">
    <option value="bulan">Per Bulan</option>
    <option value="minggu">Per Minggu</option>
</select>

{{-- BULAN --}}
<div id="input-bulan">
    <label class="font-semibold">Bulan</label>
    <input type="month" name="bulan" class="mt-1 w-full rounded border px-3 py-2">
</div>

{{-- MINGGU --}}
<div id="input-minggu" class="hidden grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="font-semibold">Dari Tanggal</label>
        <input type="date" name="tanggal_dari" class="mt-1 w-full rounded border px-3 py-2">
    </div>
    <div>
        <label class="font-semibold">Sampai Tanggal</label>
        <input type="date" name="tanggal_sampai" class="mt-1 w-full rounded border px-3 py-2">
    </div>
</div>
        {{-- ACTION --}}
        <div class="flex justify-center gap-4 pt-4">
<button
    formaction="{{ route('wali.laporan.export.range.pdf') }}"
    formmethod="GET"
    class="rounded-lg bg-red-600 px-6 py-2 text-white"
>
    Export PDF
</button>

<button
    formaction="{{ route('wali.laporan.export.range.excel') }}"
    formmethod="GET"
    class="rounded-lg bg-green-600 px-6 py-2 text-white"
>
    Export Excel
</button>

        </div>
    </form>
</div>
@endsection

@section('script')
<script>
    const mode = document.getElementById('mode');

    const bulanWrap = document.getElementById('input-bulan');
    const mingguWrap = document.getElementById('input-minggu');

    const inputBulan = bulanWrap.querySelector('input');
    const dari = document.querySelector('input[name="tanggal_dari"]');
    const sampai = document.querySelector('input[name="tanggal_sampai"]');

    function getWeekRange(date = new Date()) {
        const d = new Date(date);
        const day = d.getDay(); // 0 = Minggu
        const diffToMonday = day === 0 ? -6 : 1 - day;

        const monday = new Date(d);
        monday.setDate(d.getDate() + diffToMonday);

        const sunday = new Date(monday);
        sunday.setDate(monday.getDate() + 6);

        return {
            dari: monday.toISOString().slice(0, 10),
            sampai: sunday.toISOString().slice(0, 10),
        };
    }

    function toggleInput() {
        if (mode.value === 'bulan') {

            bulanWrap.classList.remove('hidden');
            mingguWrap.classList.add('hidden');

            inputBulan.disabled = false;
            dari.disabled = true;
            sampai.disabled = true;
        } else {
            bulanWrap.classList.add('hidden');
            mingguWrap.classList.remove('hidden');

            inputBulan.disabled = true;
            dari.disabled = false;
            sampai.disabled = false;

            const range = getWeekRange();
            dari.value = range.dari;
            sampai.value = range.sampai;
        }
    }

    mode.addEventListener('change', toggleInput);
    toggleInput();
</script>

@endsection
