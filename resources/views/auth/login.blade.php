<x-guest-layout>
    <style>
        /* Mencegah scroll dan interaksi geser di semua level */
        html, body { 
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden; /* Kunci scroll bar */
            position: fixed; /* Mencegah 'bounce' di iOS */
            touch-action: none; /* Menghapus gestur geser/zoom */
        }

        .btn-dapoer {
            background-color: #2F4F4F !important;
            transition: all 0.2s ease;
        }
        
        .btn-dapoer:active {
            background-color: #b98f10 !important;
            transform: scale(0.98);
        }

        #error-message { display: none; }
        
        /* Mengizinkan input tetap bisa diklik meskipun touch-action: none */
        input, button, a {
            touch-action: manipulation;
        }
    </style>

    <div class="fixed inset-0 z-0">
        <img src="/storage/gambar login.jpg" 
             class="w-full h-full object-cover filter brightness-50" 
             alt="Background">
    </div>

    <div class="fixed inset-0 flex flex-col justify-center items-center z-10 px-4">
        
        <div class="w-full sm:max-w-md px-6 py-8 bg-white/90 backdrop-blur-md shadow-2xl rounded-2xl">
            
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Dapoer Tipes</h2>
                <p class="text-sm text-gray-600">Silakan masuk ke akun Anda</p>
            </div>

            <div id="error-message" class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded text-sm font-medium">
                Email atau password salah.
            </div>

            <form id="login-form" method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" 
                        class="block mt-1 w-full border-gray-300 focus:border-[#b98f10] focus:ring-[#b98f10]" 
                        type="email" name="email" :value="old('email')" required autofocus />
                </div>

                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" 
                        class="block mt-1 w-full border-gray-300 focus:border-[#b98f10] focus:ring-[#b98f10]" 
                        type="password" name="password" required />
                </div>

                <div class="flex items-center justify-between mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" 
                            class="rounded border-gray-300 text-[#b98f10] shadow-sm focus:ring-[#b98f10]" 
                            name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-[#2E8B57] hover:underline font-medium" href="{{ route('password.request') }}">
                            {{ __('Lupa password?') }}
                        </a>
                    @endif
                </div>

                <div class="mt-6">
                    <x-primary-button id="submit-btn" type="submit"
                        class="w-full justify-center py-3 btn-dapoer text-white border-none outline-none">
                        {{ __('Masuk Sekarang') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('login-form').addEventListener('submit', function(e) {
            e.preventDefault(); 
            
            const form = this;
            const formData = new FormData(form);
            const errorBox = document.getElementById('error-message');
            const submitBtn = document.getElementById('submit-btn');

            errorBox.style.display = 'none';
            submitBtn.disabled = true;
            submitBtn.innerText = 'Memproses...';

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => {
                if (response.ok) {
                    window.location.href = '/dashboard'; 
                } else {
                    errorBox.style.display = 'block';
                    submitBtn.disabled = false;
                    submitBtn.innerText = 'Masuk Sekarang';
                }
            })
            .catch(error => {
                errorBox.style.display = 'block';
                submitBtn.disabled = false;
                submitBtn.innerText = 'Masuk Sekarang';
            });
        });
    </script>
</x-guest-layout>