<x-guest-layout>

<div class="min-h-screen flex bg-[#f5f3ef]">

    <!-- ================= LEFT ================= -->
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-[linear-gradient(135deg,#1a2744,#2e4a8a,#1a2744)]">

        <!-- Ornament -->
        <div class="absolute w-[450px] h-[450px] rounded-full bg-[rgba(201,162,39,0.10)] -top-44 -left-36"></div>

        <div class="absolute w-[350px] h-[350px] rounded-full bg-[rgba(201,162,39,0.10)] -bottom-24 -right-24"></div>

        <div class="relative z-10 flex flex-col items-center justify-center w-full px-16 text-center text-white">

            <!-- Logo -->
            <div class="w-28 h-28 rounded-full bg-[rgba(201,162,39,.15)] border-2 border-[#c9a227] flex items-center justify-center mb-8">
                <img src="{{ asset('img/enbi1.png') }}" class="w-16" alt="Logo">
            </div>

            <!-- Judul -->
            <h1 class="text-6xl font-black tracking-wide">SIVODO</h1>
            <h2 class="mt-4 text-2xl font-light">Sistem Voting Kinerja Dosen</h2>
            <p class="mt-8 text-lg leading-8 opacity-90 max-w-lg">
                Platform digital untuk membantu mahasiswa memberikan
                penilaian terhadap kinerja dosen secara objektif,
                transparan, aman, dan menjadi bahan evaluasi akademik.
            </p>
        </div>
    </div>

    <!-- ================= RIGHT ================= -->
    <div class="w-full lg:w-1/2 flex justify-center items-center p-8">

        <div class="bg-white w-full max-w-md rounded-3xl border border-[rgba(26,39,68,.12)] shadow-2xl p-10">

            <!-- Icon -->
            <div class="w-20 h-20 rounded-full bg-[rgba(201,162,39,.15)] border border-[#c9a227] flex items-center justify-center mx-auto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-10 h-10 text-[#c9a227]">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.964 0a9 9 0 1 0-11.964 0m11.964 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15.75 9.75A3.75 3.75 0 1 1 8.25 9.75a3.75 3.75 0 0 1 7.5 0Z" />
                </svg>
            </div>

            <h2 class="text-4xl font-bold text-[#1a2744] text-center mt-6">Selamat Datang</h2>
            <p class="text-center text-gray-500 mt-2 mb-8">Login untuk melanjutkan</p>

            <!-- ============ ALERT ERROR ============ -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-start space-x-3">
                    <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-red-700">Login Gagal!</p>
                        <ul class="mt-1 text-sm text-red-600 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <!-- ============ SESSION STATUS ============ -->
            @if (session('status'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center space-x-3">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm text-green-700">{{ session('status') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Username / Email -->
                <div class="mb-5">
                    <label class="block mb-2 font-semibold text-[#1a2744]">Username / Email</label>
                    <input
                        type="text"
                        name="login"
                        value="{{ old('login') }}"
                        placeholder="Masukkan username atau email..."
                        class="w-full rounded-xl bg-[#eef0f5] border border-[rgba(26,39,68,.12)] px-5 py-3 focus:border-[#c9a227] focus:ring-[#c9a227] focus:outline-none transition"
                        autofocus
                        autocomplete="username">
                    @error('login')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-5">
                    <label class="block mb-2 font-semibold text-[#1a2744]">password</label>
                    <input
                        type="password"
                        name="password"
                        placeholder="Masukkan password..."
                        class="w-full rounded-xl bg-[#eef0f5] border border-[rgba(26,39,68,.12)] px-5 py-3 focus:border-[#c9a227] focus:ring-[#c9a227] focus:outline-none transition"
                        autocomplete="current-password">
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember & Forgot -->
                <div class="flex justify-between items-center mb-8">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="rounded accent-[#c9a227]">
                        <span class="ml-2 text-sm text-gray-600">Remember Me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-[#c9a227] hover:text-[#1a2744] transition">
                            Lupa Password?
                        </a>
                    @endif
                </div>

                <!-- Button -->
                <button
                    type="submit"
                    class="w-full py-3 rounded-xl bg-gradient-to-r from-[#1a2744] to-[#2e4a8a] text-white font-bold shadow-lg hover:opacity-90 transition duration-200">
                    LOGIN
                </button>
            </form>

        </div>
    </div>
</div>

</x-guest-layout>
