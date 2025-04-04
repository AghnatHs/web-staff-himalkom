<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Program Kerja - {{ $department->name }}
        </h2>
    </x-slot>
    <div class="max-w-4xl mx-auto my-2 py-8 px-6 bg-gray-50 shadow-lg rounded-lg">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Tambah Program Kerja untuk {{ $department->name }}
        </h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6 border border-red-400">
                <strong>Terjadi kesalahan:</strong>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <script>
            @if ($message = session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: @json(session('success')),
                    confirmButtonText: 'OK'
                });
            @endif
        </script>

        <script>
            @if ($message = session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: @json(session('error')),
                    confirmButtonText: 'Coba Lagi'
                });
            @endif
        </script>

        <form action="{{ route('dashboard.workProgram.store', ['department' => $department]) }}" method="POST"
            enctype="multipart/form-data" class=" p-6 shadow-md rounded-md space-y-4">
            @csrf

            @php
                $fields = [
                    'name' => 'Nama Program',
                    'description' => 'Deskripsi',
                    'start_at' => 'Mulai',
                    'finished_at' => 'Selesai',
                    'funds' => 'Dana',
                    'sources_of_funds' => 'Sumber Dana',
                    'participation_total' => 'Total Partisipasi',
                    'participation_coverage' => 'Cakupan Partisipasi',
                    'lpj_url' => 'Upload LPJ (pdf, max: 5 MB)',
                    'spg_url' => 'Upload SPG (pdf, max: 5 MB)'
                ];
            @endphp

            @foreach ($fields as $field => $label)
                <div>
                    <label for="{{ $field }}"
                        class="block font-semibold text-gray-700">{{ $label }}</label>
                    @if ($field === 'description')
                        <textarea name="{{ $field }}" required
                            class="border p-3 w-full rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">{{ old($field) }}</textarea>
                    @elseif($field === 'funds')
                        <input type="text" id="funds_display" value="{{ number_format(0, 0, ',', '.') }}"
                            class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        <input type="hidden" name="funds" id="funds" value="{{ old('funds', 0) }}">
                    @elseif($field === 'participation_coverage')
                        <select name="participation_coverage" id="participation_coverage"
                            class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="Prodi">Prodi</option>
                            <option value="Sekolah">Sekolah</option>
                            <option value="IPB">IPB</option>
                            <option value="Nasional">Nasional</option>
                            <option value="Internasional">Internasional</option>
                        </select>
                    @elseif($field === 'sources_of_funds')
                        <div class="mb-4">
                            <div class="space-y-2">
                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="sources_of_funds[]" value="BPPTN"
                                        {{ in_array('BPPTN', old('sources_of_funds', [])) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span>BPPTN</span>
                                </label>

                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="sources_of_funds[]" value="Dana Sekolah"
                                        {{ in_array('Dana Sekolah', old('sources_of_funds', [])) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span>Dana Sekolah</span>
                                </label>

                                <label class="flex items-center space-x-2">
                                    <input type="checkbox" name="sources_of_funds[]" value="Mandiri"
                                        {{ in_array('Mandiri', old('sources_of_funds', [])) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span>Mandiri</span>
                                </label>
                            </div>
                        </div>
                    @elseif($field === 'lpj_url')
                        <div class="mb-4">
                            <input type="file" name="lpj_url" id="lpj_url" accept="application/pdf"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500">
                        </div>
                    @elseif($field === 'spg_url')
                        <div class="mb-4">
                            <input type="file" name="spg_url" id="spg_url" accept="application/pdf"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500">
                        </div>
                    @else
                        <input
                            type="{{ in_array($field, ['start_at', 'finished_at']) ? 'date' : (in_array($field, ['funds', 'participation_total']) ? 'number' : 'text') }}"
                            name="{{ $field }}" value="{{ old($field) }}" required
                            class="border p-3 w-full rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    @endif
                    @error($field)
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            @endforeach

            <div class="text-center">
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const displayInput = document.getElementById("funds_display");
        const hiddenInput = document.getElementById("funds");

        function formatCurrency(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'decimal'
            }).format(value);
        }

        function unformatCurrency(value) {
            return value.replace(/\./g, "");
        }

        displayInput.addEventListener("input", function(e) {
            let rawValue = this.value.replace(/\D/g, "");
            this.value = formatCurrency(rawValue);
            hiddenInput.value = unformatCurrency(rawValue);
        });
    });
</script>
