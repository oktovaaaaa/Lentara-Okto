@extends('layouts.app')

@section('title', 'Admin - Statistik Pulau')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4 text-slate-100">
    <h1 class="text-2xl font-bold mb-4">Statistik Pulau</h1>

    @if(session('status'))
        <div class="mb-4 rounded bg-emerald-600/80 px-3 py-2 text-sm">
            {{ session('status') }}
        </div>
    @endif

    {{-- PICKER PULAU --}}
    <div class="mb-6">
        <label class="block text-xs text-slate-400 mb-1">Pilih Pulau</label>
        <form method="GET" action="{{ route('admin.stats.index') }}">
            <select
                name="island"
                onchange="this.form.submit()"
                class="bg-slate-900 border border-slate-700 rounded px-3 py-2 text-sm"
            >
                @foreach($islands as $island)
                    <option value="{{ $island->slug }}" {{ $island->id === $activeIsland->id ? 'selected' : '' }}>
                        {{ $island->name }}
                    </option>
                @endforeach
            </select>
        </form>
        <p class="text-xs text-slate-500 mt-1">
            Pulau aktif: <span class="font-semibold">{{ $activeIsland->name }}</span>
        </p>
    </div>

    {{-- JUMLAH PENDUDUK --}}
    <div class="mb-8 border border-slate-700 rounded-lg p-4 bg-slate-900/70 flex items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold mb-1">Jumlah Penduduk</h2>
            <p class="text-xs text-slate-400">
                Angka ini akan tampil sebagai teks di halaman pulau.
            </p>
        </div>
        <form
            method="POST"
            action="{{ route('admin.stats.population.update', $activeIsland) }}"
            class="flex items-center gap-2"
        >
            @csrf
            <input
                type="number"
                name="population"
                value="{{ old('population', $activeIsland->population) }}"
                class="bg-slate-950 border border-slate-700 rounded px-2 py-1 text-sm w-36 text-right"
                placeholder="0"
            >
            <button
                type="submit"
                class="text-xs px-3 py-1.5 rounded bg-amber-500 text-black hover:bg-amber-400"
            >
                Simpan
            </button>
        </form>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        {{-- AGAMA --}}
        <div class="border border-slate-700 rounded-lg p-4 bg-slate-900/70">
            <h2 class="text-lg font-semibold mb-3">Agama (Pie Chart)</h2>

            <div class="space-y-2 mb-3 max-h-48 overflow-auto">
                @forelse($religions as $row)
                    <div class="flex items-center justify-between text-xs bg-slate-800/80 rounded px-2 py-1.5">
                        <span>{{ $row->label }}</span>
                        <div class="flex items-center gap-2">
                            <span>{{ $row->percentage }}%</span>
                            <form method="POST"
                                  action="{{ route('admin.stats.demographics.destroy', [$activeIsland, $row]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-500">Belum ada data agama.</p>
                @endforelse
            </div>

            <form
                method="POST"
                action="{{ route('admin.stats.demographics.store', $activeIsland) }}"
                class="mt-3 space-y-2 text-xs"
            >
                @csrf
                <input type="hidden" name="type" value="religion">

                <div class="flex gap-2">
                    <input
                        type="text"
                        name="label"
                        class="bg-slate-950 border border-slate-700 rounded px-2 py-1 flex-1"
                        placeholder="Nama agama (mis. Islam)"
                        required
                    >
                    <input
                        type="number"
                        step="0.01"
                        name="percentage"
                        class="bg-slate-950 border border-slate-700 rounded px-2 py-1 w-24 text-right"
                        placeholder="%"
                        required
                    >
                </div>
                <div class="flex justify-between items-center gap-2">
                    <input
                        type="number"
                        name="order"
                        class="bg-slate-950 border border-slate-700 rounded px-2 py-1 w-20 text-right"
                        placeholder="Urut"
                    >
                    <button
                        type="submit"
                        class="px-3 py-1.5 rounded bg-emerald-500 text-black hover:bg-emerald-400"
                    >
                        + Tambah Agama
                    </button>
                </div>
            </form>

            <div class="mt-4 h-64">
                <canvas id="religionChart"></canvas>
            </div>
        </div>

        {{-- SUKU --}}
        <div class="border border-slate-700 rounded-lg p-4 bg-slate-900/70">
            <h2 class="text-lg font-semibold mb-3">Suku (Pie Chart)</h2>

            <div class="space-y-2 mb-3 max-h-48 overflow-auto">
                @forelse($ethnicities as $row)
                    <div class="flex items-center justify-between text-xs bg-slate-800/80 rounded px-2 py-1.5">
                        <span>{{ $row->label }}</span>
                        <div class="flex items-center gap-2">
                            <span>{{ $row->percentage }}%</span>
                            <form method="POST"
                                  action="{{ route('admin.stats.demographics.destroy', [$activeIsland, $row]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-500">Belum ada data suku.</p>
                @endforelse
            </div>

            <form
                method="POST"
                action="{{ route('admin.stats.demographics.store', $activeIsland) }}"
                class="mt-3 space-y-2 text-xs"
            >
                @csrf
                <input type="hidden" name="type" value="ethnicity">

                <div class="flex gap-2">
                    <input
                        type="text"
                        name="label"
                        class="bg-slate-950 border border-slate-700 rounded px-2 py-1 flex-1"
                        placeholder="Nama suku (mis. Batak)"
                        required
                    >
                    <input
                        type="number"
                        step="0.01"
                        name="percentage"
                        class="bg-slate-950 border border-slate-700 rounded px-2 py-1 w-24 text-right"
                        placeholder="%"
                        required
                    >
                </div>
                <div class="flex justify-between items-center gap-2">
                    <input
                        type="number"
                        name="order"
                        class="bg-slate-950 border border-slate-700 rounded px-2 py-1 w-20 text-right"
                        placeholder="Urut"
                    >
                    <button
                        type="submit"
                        class="px-3 py-1.5 rounded bg-emerald-500 text-black hover:bg-emerald-400"
                    >
                        + Tambah Suku
                    </button>
                </div>
            </form>

            <div class="mt-4 h-64">
                <canvas id="ethnicityChart"></canvas>
            </div>
        </div>

        {{-- BAHASA --}}
        <div class="border border-slate-700 rounded-lg p-4 bg-slate-900/70 md:col-span-2">
            <h2 class="text-lg font-semibold mb-3">Bahasa Daerah (Bar Chart)</h2>

            <div class="space-y-2 mb-3 max-h-40 overflow-auto">
                @forelse($languages as $row)
                    <div class="flex items-center justify-between text-xs bg-slate-800/80 rounded px-2 py-1.5">
                        <span>{{ $row->label }}</span>
                        <div class="flex items-center gap-2">
                            <span>{{ $row->percentage }}%</span>
                            <form method="POST"
                                  action="{{ route('admin.stats.demographics.destroy', [$activeIsland, $row]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-500">Belum ada data bahasa.</p>
                @endforelse
            </div>

            <form
                method="POST"
                action="{{ route('admin.stats.demographics.store', $activeIsland) }}"
                class="mt-3 space-y-2 text-xs"
            >
                @csrf
                <input type="hidden" name="type" value="language">

                <div class="flex gap-2">
                    <input
                        type="text"
                        name="label"
                        class="bg-slate-950 border border-slate-700 rounded px-2 py-1 flex-1"
                        placeholder="Nama bahasa (mis. Bahasa Minang)"
                        required
                    >
                    <input
                        type="number"
                        step="0.01"
                        name="percentage"
                        class="bg-slate-950 border border-slate-700 rounded px-2 py-1 w-24 text-right"
                        placeholder="%"
                        required
                    >
                </div>
                <div class="flex justify-between items-center gap-2">
                    <input
                        type="number"
                        name="order"
                        class="bg-slate-950 border border-slate-700 rounded px-2 py-1 w-20 text-right"
                        placeholder="Urut"
                    >
                    <button
                        type="submit"
                        class="px-3 py-1.5 rounded bg-emerald-500 text-black hover:bg-emerald-400"
                    >
                        + Tambah Bahasa
                    </button>
                </div>
            </form>

            <div class="mt-4 h-72">
                <canvas id="languageChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const religionData   = @json($religions->map(fn($r) => ['label' => $r->label, 'percentage' => (float)$r->percentage]));
        const ethnicityData  = @json($ethnicities->map(fn($e) => ['label' => $e->label, 'percentage' => (float)$e->percentage]));
        const languageData   = @json($languages->map(fn($l) => ['label' => $l->label, 'percentage' => (float)$l->percentage]));

        function extractLabels(data)  { return data.map(d => d.label); }
        function extractValues(data)  { return data.map(d => d.percentage); }

        document.addEventListener('DOMContentLoaded', function() {
            const pieOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 16
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                return `${ctx.label}: ${ctx.parsed}%`;
                            }
                        }
                    }
                }
            };

            // AGAMA
            if (religionData.length) {
                new Chart(
                    document.getElementById('religionChart').getContext('2d'),
                    {
                        type: 'pie',
                        data: {
                            labels: extractLabels(religionData),
                            datasets: [{
                                data: extractValues(religionData),
                                backgroundColor: [
                                    '#FF6384','#36A2EB','#FFCE56','#4BC0C0','#9966FF','#FF9F40'
                                ],
                                borderColor: '#111827',
                                borderWidth: 2
                            }]
                        },
                        options: pieOptions
                    }
                );
            }

            // SUKU
            if (ethnicityData.length) {
                new Chart(
                    document.getElementById('ethnicityChart').getContext('2d'),
                    {
                        type: 'pie',
                        data: {
                            labels: extractLabels(ethnicityData),
                            datasets: [{
                                data: extractValues(ethnicityData),
                                backgroundColor: [
                                    '#36A2EB','#FF6384','#4BC0C0','#FFCE56','#9966FF','#FF9F40'
                                ],
                                borderColor: '#111827',
                                borderWidth: 2
                            }]
                        },
                        options: pieOptions
                    }
                );
            }

            // BAHASA
            if (languageData.length) {
                new Chart(
                    document.getElementById('languageChart').getContext('2d'),
                    {
                        type: 'bar',
                        data: {
                            labels: extractLabels(languageData),
                            datasets: [{
                                label: 'Persentase penutur',
                                data: extractValues(languageData),
                                backgroundColor: 'rgba(56, 189, 248, 0.6)',
                                borderColor: 'rgba(56, 189, 248, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    max: 100,
                                    ticks: { callback: value => value + '%' }
                                }
                            }
                        }
                    }
                );
            }
        });
    </script>
@endpush
