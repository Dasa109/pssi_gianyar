<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Klub - PSSI Gianyar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex justify-center items-center min-h-screen p-4">

    <div class="max-w-xl w-full bg-white rounded-xl shadow-lg p-8 border border-emerald-100">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-emerald-700">Pendaftaran Klub Baru</h2>
            <p class="text-gray-500 mt-2">Portal Resmi PSSI Kabupaten Gianyar</p>
        </div>

        {{-- Pesan Sukses --}}
        @if (session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded">
                <p class="font-bold">Berhasil!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        {{-- Pesan Error Validasi --}}
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Action mengarah ke route club.store, wajib pakai enctype untuk upload file --}}
        <form action="{{ route('club.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            {{-- Token Keamanan Laravel --}}
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Klub</label>
                <input type="text" name="name" value="{{ old('name') }}" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition"
                    placeholder="Contoh: PS Gianyar">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Telepon Official</label>
                <input type="text" name="phone" value="{{ old('phone') }}" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition"
                    placeholder="081234567890">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Sekretariat</label>
                <textarea name="address" required rows="3" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition"
                    placeholder="Masukkan alamat lengkap sekretariat klub">{{ old('address') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Dokumen Legalitas</label>
                <p class="text-xs text-gray-500 mb-2">Upload surat pengesahan/legalitas klub. Format PDF atau ZIP (Maks. 5MB).</p>
                <input type="file" name="legal_document" accept=".pdf,.zip" required 
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition">
            </div>

            <button type="submit" 
                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 mt-4">
                Kirim Pendaftaran Klub
            </button>
        </form>
    </div>

</body>
</html>