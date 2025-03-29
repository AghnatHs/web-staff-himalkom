<x-app-layout>
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md mt-6">

        <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $workProgram->name }}</h1>

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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-gray-100 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Deskripsi:</p>
                <p class="text-gray-800">{{ $workProgram->description }}</p>
            </div>

            <div class="bg-gray-100 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Periode:</p>
                <p class="text-gray-800">{{ date('d M Y', strtotime($workProgram->start_at)) }} -
                    {{ date('d M Y', strtotime($workProgram->finished_at)) }}</p>
            </div>

            <div class="bg-gray-100 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Dana:</p>
                <p class="text-gray-800 font-semibold">Rp {{ number_format($workProgram->funds, 0, ',', '.') }}</p>
            </div>

            <div class="bg-gray-100 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Sumber Dana:</p>
                <p class="text-gray-800">{{ $workProgram->sources_of_funds }}</p>
            </div>

            <div class="bg-gray-100 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Total Partisipasi:</p>
                <p class="text-gray-800">{{ $workProgram->participation_total }} Orang</p>
            </div>

            <div class="bg-gray-100 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Cakupan Partisipasi:</p>
                <p class="text-gray-800">{{ $workProgram->participation_coverage }}</p>
            </div>
        </div>


        <div class="mt-6 flex justify-between">
            <a href="{{ route('dashboard.workProgram.index', ['slug' => $workProgram->department->slug]) }}"
                class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                ← Kembali
            </a>

            <a href="{{ route('dashboard.workProgram.edit', ['workProgram' => $workProgram, 'slug' => $workProgram->department->slug]) }}"
                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                Edit Program
            </a>
            <form
                action="{{ route('dashboard.workProgram.destroy', ['workProgram' => $workProgram, 'slug' => $workProgram->department->slug]) }}"
                method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus program ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                    Hapus Program
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
