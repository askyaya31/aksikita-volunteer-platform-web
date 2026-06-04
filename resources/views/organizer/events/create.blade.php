@extends('layouts.organizer')
@section('title', 'Buat Event Baru')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="reveal mb-7">
        <a href="{{ route('organizer.events') }}"
           class="inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-brand-600 transition-colors font-medium mb-3">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
            </svg>
            Kembali ke daftar event
        </a>
        <h1 class="text-2xl font-bold text-slate-900">Buat Event Baru</h1>
        <p class="text-sm text-slate-500 mt-1">
            Event akan masuk ke antrian review admin sebelum dipublikasikan.
        </p>
    </div>

    @if($errors->any())
        <div class="reveal mb-6 bg-red-50 border border-red-200 rounded-2xl px-5 py-4">
            <p class="text-sm font-semibold text-red-700 mb-2">Perbaiki kesalahan berikut:</p>
            <ul class="space-y-1">
                @foreach($errors->all() as $error)
                    <li class="text-sm text-red-600 flex items-start gap-2">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="flex-shrink-0 mt-0.5">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('organizer.events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="reveal bg-white rounded-2xl p-6 mb-4" style="box-shadow: var(--shadow-card); border: 1px solid rgba(59,130,246,.07)">
            <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-5">Informasi Utama</h2>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Judul Event <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" value="{{ old('title') }}"
                           placeholder="Contoh: Bersih Pantai Bersama Komunitas Hijau"
                           class="input-brand @error('title') border-red-400 @enderror">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Deskripsi <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" rows="5"
                              placeholder="Ceritakan tentang event ini — tujuannya, kegiatannya, dan dampak yang ingin dicapai."
                              class="input-brand resize-none @error('description') border-red-400 @enderror">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Syarat Peserta</label>
                    <textarea name="requirements" rows="3"
                              placeholder="Contoh: Usia minimal 17 tahun. Membawa perlengkapan sendiri. Wajib hadir tepat waktu."
                              class="input-brand resize-none">{{ old('requirements') }}</textarea>
                </div>
            </div>
        </div>

        <div class="reveal bg-white rounded-2xl p-6 mb-4" style="box-shadow: var(--shadow-card); border: 1px solid rgba(59,130,246,.07)">
            <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-5">Lokasi</h2>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Nama Tempat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="location_name" value="{{ old('location_name') }}"
                           placeholder="Contoh: Taman Nasional Baluran"
                           class="input-brand @error('location_name') border-red-400 @enderror">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Lengkap</label>
                    <input type="text" name="location_address" value="{{ old('location_address') }}"
                           placeholder="Jalan, kelurahan, kecamatan..."
                           class="input-brand">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Kota <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="city" value="{{ old('city') }}"
                               class="input-brand @error('city') border-red-400 @enderror">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Provinsi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="province" value="{{ old('province') }}"
                               class="input-brand @error('province') border-red-400 @enderror">
                    </div>
                </div>
            </div>
        </div>
        <div class="reveal bg-white rounded-2xl p-6 mb-4" style="box-shadow: var(--shadow-card); border: 1px solid rgba(59,130,246,.07)">
            <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-5">Jadwal & Kuota</h2>

            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Tanggal Mulai <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="start_date" value="{{ old('start_date') }}"
                               min="{{ date('Y-m-d') }}"
                               class="input-brand @error('start_date') border-red-400 @enderror">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Tanggal Selesai <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="end_date" value="{{ old('end_date') }}"
                               class="input-brand @error('end_date') border-red-400 @enderror">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Jam Mulai</label>
                        <input type="time" name="start_time" value="{{ old('start_time') }}"
                               class="input-brand">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Jam Selesai</label>
                        <input type="time" name="end_time" value="{{ old('end_time') }}"
                               class="input-brand">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Kuota <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="quota" value="{{ old('quota', 30) }}" min="1"
                               class="input-brand @error('quota') border-red-400 @enderror">
                    </div>
                </div>
            </div>
        </div>

        <div class="reveal bg-white rounded-2xl p-6 mb-4" style="box-shadow: var(--shadow-card); border: 1px solid rgba(59,130,246,.07)">
            <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Kategori <span class="text-red-500">*</span></h2>
            <p class="text-xs text-slate-400 mb-4">Pilih satu atau lebih kategori yang sesuai</p>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                @foreach($categories as $cat)
                    <label class="flex items-center gap-2.5 cursor-pointer p-3 rounded-xl border transition-all
                                  border-slate-200 hover:border-brand-400 has-[:checked]:border-brand-500 has-[:checked]:bg-brand-50">
                        <input type="checkbox" name="category_ids[]" value="{{ $cat->id }}"
                               {{ in_array($cat->id, old('category_ids', [])) ? 'checked' : '' }}
                               class="w-4 h-4 accent-brand-500 rounded">
                        <span class="text-sm text-slate-700 font-medium">{{ $cat->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="reveal bg-white rounded-2xl p-6 mb-6" style="box-shadow: var(--shadow-card); border: 1px solid rgba(59,130,246,.07)">
            <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-5">Narahubung & Media</h2>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Narahubung</label>
                    <input type="text" name="contact_person" value="{{ old('contact_person') }}"
                           class="input-brand">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nomor HP</label>
                    <input type="text" name="contact_phone" value="{{ old('contact_phone') }}"
                           placeholder="08xxxxxxxxxx"
                           class="input-brand">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Poster Event</label>
                <div class="border-2 border-dashed border-slate-200 hover:border-brand-400 transition-colors rounded-xl px-4 py-6 text-center cursor-pointer"
                     onclick="document.getElementById('poster-input').click()">
                    <div id="poster-preview" class="hidden mb-3">
                        <img id="poster-img" src="" alt="Preview poster" class="max-h-40 mx-auto rounded-lg object-cover">
                    </div>
                    <div id="poster-placeholder">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#93C5FD" stroke-width="1.5" stroke-linecap="round" class="mx-auto mb-2">
                            <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/>
                            <polyline points="21 15 16 10 5 21"/>
                        </svg>
                        <p class="text-sm text-slate-500 font-medium">Klik untuk upload poster</p>
                        <p class="text-xs text-slate-400 mt-1">JPG, PNG, WEBP — maks. 2MB</p>
                    </div>
                    <input type="file" id="poster-input" name="poster"
                           accept="image/jpg,image/jpeg,image/png,image/webp"
                           class="hidden"
                           onchange="previewPoster(this)">
                </div>
            </div>
        </div>
        <div class="reveal flex gap-3">
            <button type="submit"
                    class="btn-primary ripple flex-1 py-3 text-sm justify-center">
                Buat Event &amp; Ajukan Review
            </button>
            <a href="{{ route('organizer.events') }}"
               class="btn-outline px-6 py-3 text-sm">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
function previewPoster(input) {
    const preview = document.getElementById('poster-preview');
    const placeholder = document.getElementById('poster-placeholder');
    const img = document.getElementById('poster-img');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            img.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection
