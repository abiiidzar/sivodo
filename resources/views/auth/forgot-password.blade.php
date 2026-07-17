<x-guest-layout>

<div class="min-h-screen flex items-center justify-center bg-[linear-gradient(135deg,#1a2744,#2e4a8a,#1a2744)] relative overflow-hidden">

    <!-- Ornamen -->
    <div class="absolute w-[450px] h-[450px] rounded-full bg-[rgba(201,162,39,.10)] -top-40 -left-40"></div>
    <div class="absolute w-[350px] h-[350px] rounded-full bg-[rgba(201,162,39,.10)] -bottom-28 -right-28"></div>

    <!-- Card -->
    <div class="relative z-10 bg-white w-full max-w-lg rounded-3xl shadow-2xl p-10">


        <!-- Icon Email -->
        <div class="w-20 h-20 mx-auto mt-8 rounded-full bg-[rgba(201,162,39,.15)] border border-[#c9a227] flex items-center justify-center">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-10 h-10 text-[#c9a227]"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M3 8l9 6 9-6m-18 0v8a2 2 0 002 2h14a2 2 0 002-2V8"/>

            </svg>

        </div>

        <h2 class="text-3xl font-bold text-center text-[#1a2744] mt-6">
            Lupa Password
        </h2>

        <p class="text-center text-gray-500 mt-3 mb-8 leading-7">
            Masukkan email yang telah terdaftar.
            Kami akan mengirimkan tautan untuk mengatur ulang password akun Anda.
        </p>

        <x-auth-session-status
            class="mb-4"
            :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">

            @csrf

            <div class="mb-6">

                <label class="block mb-2 font-semibold text-[#1a2744]">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    placeholder="Masukkan email..."
                    class="w-full rounded-xl bg-[#eef0f5] border border-gray-300 px-5 py-3 focus:border-[#c9a227] focus:ring-[#c9a227]">

                <x-input-error
                    :messages="$errors->get('email')"
                    class="mt-2"/>

            </div>

            <button
                type="submit"
                class="w-full py-3 rounded-xl bg-gradient-to-r from-[#1a2744] to-[#2e4a8a] text-white font-bold hover:scale-105 transition duration-300">

                Kirim Link Reset Password

            </button>

        </form>

        <div class="text-center mt-6">

            <a href="{{ route('login') }}"
               class="text-[#c9a227] font-semibold hover:text-[#1a2744]">

                ← Kembali ke Login

            </a>

        </div>

    </div>

</div>

</x-guest-layout>
