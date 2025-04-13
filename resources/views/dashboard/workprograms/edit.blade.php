<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row items-center">
            <div class="text-[11px] text-gray-500 font-medium md:text-sm">
                <nav class="flex items-center space-x-1 md:space-x-2">
                    <a href="{{ route('dashboard.workProgram.index', ['department' => $workProgram->department]) }}"
                        class="hover:underline hover:text-[#111B5A] cursor-pointer">
                        Program Kerja
                    </a>
                    <span class="text-gray-400">/</span>
                    <a href="{{ route('dashboard.workProgram.index', ['department' => $workProgram->department]) }}"
                        class="hover:underline hover:text-[#111B5A] cursor-pointer">
                        {{ $workProgram->department->name }}
                    </a>
                    <span class="text-gray-400">/</span>
                    <a href="{{ route('dashboard.workProgram.detail', ['workProgram' => $workProgram, 'department' => $workProgram->department]) }}"
                        class="hover:underline hover:text-[#111B5A] cursor-pointer ">
                        {{ $workProgram->name }}
                    </a>
                    <span class="text-gray-400">/</span>
                    <span class="text-gray-800 font-semibold">
                        Edit
                    </span>
                </nav>
            </div>
        </div>
    </x-slot>
    <div
        class="relative max-w-[90dvw] lg:max-w-6xl mx-auto mt-2 mb-8 p-2 bg-white rounded-xl md:rounded-2xl lg:rounded-3xl shadow-lg 
        before:absolute before:inset-0 before:-z-10 before:bg-gradient-to-r before:from-gray-200 before:to-gray-100 
        before:rounded-[inherit] before:p-[0.5px]">
        <div class="bg-white rounded-lg md:rounded-xl lg:rounded-2xl p-4 md:p-6 border border-gray-200">
            <h2 class="font-extrabold text-gray-900 md:mb-2 text-center text-lg md:text-xl lg:text-3xl">Edit Program
                Kerja - {{ $workProgram->name }}</h2>
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

            <form
                action="{{ route('dashboard.workProgram.update', ['workProgram' => $workProgram, 'department' => $workProgram->department]) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="title" class="mb-1 block font-normal text-gray-600 text-sm md:text-lg">Judul
                        Program</label>
                    <input type="text" name="name" id="title" value="{{ $workProgram->name }}"
                        class="bg-[#FAFAFA] border border-gray-200 shadow-sm rounded-md p-2 w-full focus:ring-1 focus:ring-gray-100 focus:shadow-md focus:border-gray-100 focus:outline-none text-gray-700 text-sm md:text-md lg:text-lg">
                </div>

                <div class="mb-4">
                    <label for="description"
                        class="mb-1 block font-normal text-gray-600 text-sm md:text-lg">Deskripsi</label>
                    <textarea name="description" id="description" rows="5"
                        class="bg-[#FAFAFA] border border-gray-200 shadow-sm rounded-md p-2 w-full focus:ring-1 focus:ring-gray-100 focus:shadow-md focus:border-gray-100 focus:outline-none text-gray-700 text-sm md:text-md lg:text-lg">{{ $workProgram->description }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="start_at" class="mb-1 block font-normal text-gray-600 text-sm md:text-lg">Tanggal
                        Mulai</label>
                    <input type="date" name="start_at" id="start_at" value="{{ $workProgram->start_at }}"
                        class="bg-[#FAFAFA] border border-gray-200 shadow-sm rounded-md p-2 w-full focus:ring-1 focus:ring-gray-100 focus:shadow-md focus:border-gray-100 focus:outline-none text-sm text-gray-700  md:text-md lg:text-lg">
                </div>

                <div class="mb-4">
                    <label for="finished_at" class="mb-1 block font-normal text-gray-600 text-sm md:text-lg">Tanggal
                        Selesai</label>
                    <input type="date" name="finished_at" id="finished_at" value="{{ $workProgram->finished_at }}"
                        class="bg-[#FAFAFA] border border-gray-200 shadow-sm rounded-md p-2 w-full focus:ring-1 focus:ring-gray-100 focus:shadow-md focus:border-gray-100 focus:outline-none text-sm text-gray-700  md:text-md lg:text-lg">
                </div>

                <div class="mb-4">
                    <label for="funds" class="mb-1 block font-normal text-gray-600 text-sm md:text-lg">Dana</label>
                    <input type="text" id="funds_display"
                        value="{{ number_format($workProgram->funds, 0, ',', '.') }}"
                        class="bg-[#FAFAFA] border border-gray-200 shadow-sm rounded-md p-2 w-full focus:ring-1 focus:ring-gray-100 focus:shadow-md focus:border-gray-100 focus:outline-none text-gray-700 text-sm md:text-md lg:text-lg">
                    <input type="hidden" name="funds" id="funds" value="{{ $workProgram->funds }}">
                </div>

                <div class="mb-4">
                    <label for="sources_of_funds" class="mb-1 block font-normal text-gray-600 text-sm md:text-lg">
                        Sumber Dana
                    </label>

                    <div class="space-y-2">
                        @php
                            $selectedSources = is_array($workProgram->sources_of_funds)
                                ? $workProgram->sources_of_funds
                                : json_decode($workProgram->sources_of_funds, true) ?? [];
                        @endphp


                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="sources_of_funds[]" value="BPPTN"
                                {{ in_array('BPPTN', $selectedSources) ? 'checked' : '' }}
                                class="bg-[#FAFAFA] border border-gray-200 shadow-sm rounded-md focus:ring-1 focus:ring-gray-100 focus:shadow-lg focus:border-gray-100 focus:outline-none text-gray-700  text-sm md:text-md lg:text-lg">
                            <span>BPPTN</span>
                        </label>

                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="sources_of_funds[]" value="Dana Sekolah"
                                {{ in_array('Dana Sekolah', $selectedSources) ? 'checked' : '' }}
                                class="bg-[#FAFAFA] border border-gray-200 shadow-sm rounded-md focus:ring-1 focus:ring-gray-100 focus:shadow-lg focus:border-gray-100 focus:outline-none text-gray-700  text-sm md:text-md lg:text-lg">
                            <span>Dana Sekolah</span>
                        </label>

                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="sources_of_funds[]" value="Mandiri"
                                {{ in_array('Mandiri', $selectedSources) ? 'checked' : '' }}
                                class="bg-[#FAFAFA] border border-gray-200 shadow-sm rounded-md focus:ring-1 focus:ring-gray-100 focus:shadow-lg focus:border-gray-100 focus:outline-none text-gray-700  text-sm md:text-md lg:text-lg">
                            <span>Mandiri</span>
                        </label>
                    </div>
                </div>


                <div class="mb-4">
                    <label for="participation_total"
                        class="mb-1 block font-normal text-gray-600 text-sm md:text-lg">Jumlah Partisipan</label>
                    <input type="number" name="participation_total" id="participation_total"
                        value="{{ $workProgram->participation_total }}"
                        class="bg-[#FAFAFA] border border-gray-200 shadow-sm rounded-md p-2 w-full focus:ring-1 focus:ring-gray-100 focus:shadow-md focus:border-gray-100 focus:outline-none text-sm text-gray-700  md:text-md lg:text-lg">
                </div>

                <div class="mb-4">
                    <label for="participation_coverage" class="mb-1 block font-normal text-gray-600 text-sm md:text-lg">
                        Cakupan Partisipasi
                    </label>

                    <select name="participation_coverage" id="participation_coverage"
                        class="select2 bg-[#FAFAFA] border border-gray-200 shadow-sm rounded-md p-2 w-full focus:ring-1 focus:ring-gray-100 focus:shadow-md focus:border-gray-100 focus:outline-none text-gray-700  text-sm md:text-md lg:text-lg">
                        <option class="text-gray-700  text-sm md:text-md lg:text-lg" value="Prodi"
                            {{ $workProgram->participation_coverage == 'Prodi' ? 'selected' : '' }}>
                            Prodi</option>
                        <option class="text-gray-700  text-sm md:text-md lg:text-lg" value="Sekolah"
                            {{ $workProgram->participation_coverage == 'Sekolah' ? 'selected' : '' }}>
                            Sekolah</option>
                        <option class="text-gray-700  text-sm md:text-md lg:text-lg" value="IPB"
                            {{ $workProgram->participation_coverage == 'IPB' ? 'selected' : '' }}>
                            IPB
                        </option>
                        <option class="text-gray-700  text-sm md:text-md lg:text-lg" value="Nasional"
                            {{ $workProgram->participation_coverage == 'Nasional' ? 'selected' : '' }}>Nasional
                        </option>
                        <option class="text-gray-700  text-sm md:text-md lg:text-lg" value="Internasional"
                            {{ $workProgram->participation_coverage == 'Internasional' ? 'selected' : '' }}>
                            Internasional
                        </option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="proposal_url" class="mb-1 block font-normal text-gray-600 text-sm md:text-lg">Upload
                        Proposal
                        (pdf, max: 5
                        MB)</label>
                    @if ($workProgram->proposal_url)
                        <div class="bg-gray-100 p-2 md:p-4 rounded-lg">
                            <p class="text-sm md:text-md lg:text-lg text-gray-600">File Proposal:</p>
                            <p class="text-xs text-gray-800">{{ explode('/', $workProgram->proposal_url)[1] }}</p>
                            <p class="text-xs text-red-600">Mengunggah file baru akan menimpa file lama, kosongkan jika
                                tidak ingin mengubah file</p>
                        </div>
                    @else
                        <div class="bg-red-200 p-2 md:p-4 mb-2 rounded-lg">
                            <p class="text-gray-800">File Proposal belum diunggah, silahkan unggah disini</p>
                        </div>
                    @endif

                    <input type="file" name="proposal_url" id="proposal_url" accept="application/pdf"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label for="lpj_url" class="mb-1 block font-normal text-gray-600 text-sm md:text-lg">Upload LPJ
                        (pdf, max: 5
                        MB)</label>
                    @if ($workProgram->lpj_url)
                        <div class="bg-gray-100 p-2 md:p-4 rounded-lg">
                            <p class="text-sm md:text-md lg:text-lg text-gray-600">File LPJ:</p>
                            <p class="text-xs text-gray-800">{{ explode('/', $workProgram->lpj_url)[1] }}</p>
                            <p class="text-xs text-red-600">Mengunggah file baru akan menimpa file lama, kosongkan jika
                                tidak ingin mengubah file</p>
                        </div>
                    @else
                        <div class="bg-red-200 p-2 md:p-4 mb-2 rounded-lg">
                            <p class="text-gray-800">File LPJ belum diunggah, silahkan unggah disini</p>
                        </div>
                    @endif

                    <input type="file" name="lpj_url" id="lpj_url" accept="application/pdf"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label for="spg_url" class="mb-1 block font-normal text-gray-600 text-sm md:text-lg">Upload SPJ
                        (pdf, max: 5
                        MB)</label>
                    @if ($workProgram->spg_url)
                        <div class="bg-gray-100 p-2 md:p-4 rounded-lg">
                            <p class="text-sm md:text-md lg:text-lg text-gray-600">File SPJ:</p>
                            <p class="text-xs text-gray-800">{{ explode('/', $workProgram->spg_url)[1] }}</p>
                            <p class="text-xs text-red-600">Mengunggah file baru akan menimpa file lama, kosongkan jika
                                tidak ingin mengubah file</p>
                        </div>
                    @else
                        <div class="bg-red-200 p-2 md:p-4 mb-2 rounded-lg">
                            <p class="text-gray-800">File SPG belum diunggah, silahkan unggah disini</p>
                        </div>
                    @endif

                    <input type="file" name="spg_url" id="spg_url" accept="application/pdf"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label for="komnews_url" class="mb-1 block font-normal text-gray-600 text-sm md:text-lg">Upload
                        Komnews/Berita
                        (pdf, max: 5
                        MB)</label>
                    @if ($workProgram->komnews_url)
                        <div class="bg-gray-100 p-2 md:p-4 rounded-lg">
                            <p class="text-sm md:text-md lg:text-lg text-gray-600">File Komnews:</p>
                            <p class="text-xs text-gray-800">{{ explode('/', $workProgram->komnews_url)[1] }}</p>
                            <p class="text-xs text-red-600">Mengunggah file baru akan menimpa file lama, kosongkan jika
                                tidak ingin mengubah file</p>
                        </div>
                    @else
                        <div class="bg-red-200 p-2 md:p-4 mb-2 rounded-lg">
                            <p class="text-gray-800">File Komnews belum diunggah, silahkan unggah disini</p>
                        </div>
                    @endif

                    <input type="file" name="komnews_url" id="komnews_url" accept="application/pdf"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('dashboard.workProgram.detail', ['workProgram' => $workProgram, 'department' => $workProgram->department]) }}"
                        class="mt-2 md:mt-4 bg-gray-500 text-white px-4 py-2 md:px-6 md:py-2 rounded-xl shadow hover:bg-gray-600 hover:transition text-sm md:text-md lg:text-lg">
                        Batal
                    </a>
                    <button type="submit"
                        class="mt-2 md:mt-4 bg-[#14267B] text-white px-4 py-2 md:px-6 md:py-2 rounded-xl shadow hover:bg-[#111B5A] hover:transition text-sm md:text-md lg:text-lg">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const displayInput = document.getElementById("funds_display");
        const fundsHiddenInput = document.getElementById("funds");

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
            fundsHiddenInput.value = unformatCurrency(rawValue);
        });
    });

    $(document).ready(function() {
        $('#participation_coverage').select2();
    });
</script>
