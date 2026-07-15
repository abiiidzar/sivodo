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

                <img
                    src="{{ asset('img/enbi1.png') }}"
                    class="w-16"
                    alt="Logo">

            </div>

            <!-- Judul -->
            <h1 class="text-6xl font-black tracking-wide">
                SIVODO
            </h1>

            <h2 class="mt-4 text-2xl font-light">
                Sistem Voting Kinerja Dosen
            </h2>

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

                <svg
                    class="w-10 h-10 text-[#c9a227]"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5.121 17.804A9 9 0 1118.364 4.56M15 11a3 3 0 11-6 0 3 3 0 016 0zm-3 4c-2.67 0-8 1.34-8 4v1h16v-1c0-2.66-5.33-4-8-4z"/>

                </svg>

            </div>

            <h2 class="text-4xl font-bold text-[#1a2744] text-center mt-6">

                Selamat Datang

            </h2>

            <p class="text-center text-gray-500 mt-2 mb-8">

                Login untuk melanjutkan

            </p>

            <form method="POST" action="{{ route('login') }}">

                @csrf

                <!-- Username -->
                <div class="mb-5">

                    <label class="block mb-2 font-semibold text-[#1a2744]">

                        Username / Email

                    </label>

                    <input
                        type="text"
                        name="login"
                        value="{{ old('login') }}"
                        placeholder="Masukkan username..."
                        class="w-full rounded-xl bg-[#eef0f5] border border-[rgba(26,39,68,.12)] px-5 py-3 focus:border-[#c9a227] focus:ring-[#c9a227]">

                    <x-input-error
                        :messages="$errors->get('login')"
                        class="mt-2"/>

                </div>

                <!-- Password -->

                <div class="mb-5">

                    <label class="block mb-2 font-semibold text-[#1a2744]">

                        Password

                    </label>

                    <input
                        type="password"
                        name="password"
                        placeholder="Masukkan password..."
                        class="w-full rounded-xl bg-[#eef0f5] border border-[rgba(26,39,68,.12)] px-5 py-3 focus:border-[#c9a227] focus:ring-[#c9a227]">

                    <x-input-error
                        :messages="$errors->get('password')"
                        class="mt-2"/>

                </div>

                <!-- Remember -->

                <div class="flex justify-between items-center mb-8">

                    <label class="flex items-center">

                        <input
                            type="checkbox"
                            name="remember"
                            class="rounded accent-[#c9a227]">

                        <span class="ml-2 text-sm text-gray-600">

                            Remember Me

                        </span>

                    </label>

                    @if (Route::has('password.request'))

                        <a
                            href="{{ route('password.request') }}"
                            class="text-sm text-[#c9a227] hover:text-[#1a2744]">

                            Lupa Password?

                        </a>

                    @endif

                </div>

                <!-- Button -->

                <button
                    type="submit"
                    class="w-full py-3 rounded-xl bg-gradient-to-r from-[#1a2744] to-[#2e4a8a] text-white font-bold shadow-lg hover:opacity-90 transition">

                    LOGIN

                </button>

            </form>

        </div>

    </div>

</div>

</x-guest-layout>
