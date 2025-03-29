<x-app-layout>
    <div class="max-w-6xl mx-auto py-8 px-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Program Kerja - {{ $department->name }}</h1>

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


        <div class="flex justify-end mb-6">
            <a href="{{ route('dashboard.workProgram.create', ['department' => $department, 'slug' => $department->slug]) }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                Tambah Program Kerja
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($department->workPrograms as $workProgram)
                <div class="bg-white shadow-lg rounded-lg p-6 border border-gray-200 hover:shadow-xl transition">
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ $workProgram->name }}</h2>
                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($workProgram->description, 100, '...') }}</p>
                    <p class="text-gray-500 text-sm mb-4">{{ $workProgram->start_at }} - {{ $workProgram->finished_at }}
                    </p>
                    <a href="{{ route('dashboard.workProgram.detail', ['workProgram' => $workProgram, 'slug' => $department->slug]) }}"
                        class="inline-block text-blue-600 font-semibold hover:underline">
                        Selengkapnya →
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
