@extends('layouts.guest')
@section('title', 'Pilih Peran — AksiKita')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 bg-surface">
    <div class="w-full max-w-lg">

        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">
                Selamat datang, {{ $googleUser['name'] }}!
            </h1>
            <p class="text-gray-500 mt-1 text-sm">
                Akun Google kamu belum terdaftar. Pilih peran untuk melanjutkan.
            </p>
        </div>

        {{-- Avatar --}}
        <div class="flex justify-center mb-6">
            <div class="w-16 h-16 rounded-full bg-primary flex items-center justify-center text-white text-2xl font-bold ring-4 ring-white shadow-md">
                {{ strtoupper(substr($googleUser['name'], 0, 1)) }}
            </div>
        </div>

        {{-- Error --}}
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-5 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('auth.google.role.post') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-4 mb-6" id="roleCards">

                {{-- Volunteer --}}
                <div class="role-card border-2 border-gray-200 rounded-2xl p-5 text-center cursor-pointer transition-all duration-200 hover:border-blue-300 hover:shadow-md"
                     data-value="volunteer"
                     onclick="selectRole('volunteer')">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <p class="font-semibold text-gray-800 text-sm">Volunteer</p>
                    <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                        Daftar &amp; ikuti kegiatan sosial di sekitarmu
                    </p>
                </div>

                {{-- Organisasi --}}
                <div class="role-card border-2 border-gray-200 rounded-2xl p-5 text-center cursor-pointer transition-all duration-200 hover:border-blue-300 hover:shadow-md"
                     data-value="organization"
                     onclick="selectRole('organization')">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <p class="font-semibold text-gray-800 text-sm">Organisasi</p>
                    <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                        Buat &amp; kelola kegiatan, rekrut relawan
                    </p>
                </div>
            </div>

            <input type="hidden" name="role" id="roleInput" value="{{ old('role') }}">

            {{-- Field nama organisasi --}}
            <div id="org-name-wrapper" class="mb-5 {{ old('role') === 'organization' ? '' : 'hidden' }}">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Nama Organisasi <span class="text-red-400">*</span>
                </label>
                <input type="text"
                       name="organization_name"
                       id="organization_name"
                       value="{{ old('organization_name') }}"
                       placeholder="Masukkan nama organisasi Anda"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p class="text-xs text-gray-400 mt-1">
                    Nama ini akan ditampilkan kepada publik setelah diverifikasi admin.
                </p>
            </div>

            <button type="submit"
                    id="submitBtn"
                    disabled
                    class="w-full text-white font-semibold py-3 rounded-xl text-sm transition-all duration-200"
                    style="background: #3B82F6; opacity: 0.4; cursor: not-allowed;">
                Lanjutkan →
            </button>
        </form>

        <p class="text-center text-xs text-gray-400 mt-5">
            Dengan melanjutkan, kamu menyetujui
            <a href="#" class="underline hover:text-gray-600">Syarat &amp; Ketentuan</a>
            AksiKita.
        </p>

    </div>
</div>

<script>
    var currentRole = '{{ old('role') }}' || null;

    if (currentRole) {
        selectRole(currentRole);
    }

    function selectRole(role) {
        currentRole = role;
        document.getElementById('roleInput').value = role;
        document.querySelectorAll('.role-card').forEach(function(card) {
            if (card.getAttribute('data-value') === role) {
                card.style.borderColor = '#3B82F6';
                card.style.backgroundColor = '#EFF6FF';
                card.style.boxShadow = '0 4px 12px rgba(59,130,246,0.15)';
            } else {
                card.style.borderColor = '#E5E7EB';
                card.style.backgroundColor = '';
                card.style.boxShadow = '';
            }
        });

        var orgWrapper = document.getElementById('org-name-wrapper');
        var orgInput   = document.getElementById('organization_name');
        if (role === 'organization') {
            orgWrapper.classList.remove('hidden');
            orgInput.required = true;
        } else {
            orgWrapper.classList.add('hidden');
            orgInput.required = false;
        }

        var btn = document.getElementById('submitBtn');
        btn.disabled = false;
        btn.style.opacity = '1';
        btn.style.cursor  = 'pointer';
    }
</script>
@endsection