<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- NAME --}}
        <div>
            <x-input-label for="name">
                Nama <span class="text-red-500">*</span>
            </x-input-label>
            <x-text-input
                id="name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
                placeholder="Nama Penuh"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- EMAIL --}}
        <div class="mt-4">
            <x-input-label for="email">
                Emel Rasmi <span class="text-red-500">*</span>
            </x-input-label>
            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                pattern="^[a-zA-Z0-9._%+-]+@selangor\.gov\.my$"
                placeholder="nama@selangor.gov.my"
                autocomplete="username"
            />
            <p class="text-xs text-gray-500 mt-1">
                * Mesti menggunakan emel rasmi @selangor.gov.my
            </p>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- PHONE --}}
        <div class="mt-4">
            <x-input-label for="phone">
                Nombor Telefon <span class="text-red-500">*</span>
            </x-input-label>
            <x-text-input
                id="phone"
                class="block mt-1 w-full"
                type="text"
                name="phone"
                value="{{ old('phone') }}"
                required
                pattern="[0-9]{10,11}"
                inputmode="numeric"
                placeholder="Contoh: 0192226545"
                oninput="this.value=this.value.replace(/[^0-9]/g,'')"
            />
            <p class="text-xs text-gray-500 mt-1">
                * Masukkan nombor tanpa simbol (-)
            </p>
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        {{-- BAHAGIAN --}}
        <div class="mt-4">
            <x-input-label for="bahagian_id">
                Bahagian <span class="text-red-500">*</span>
            </x-input-label>
            <select
                id="bahagian_id"
                name="bahagian_id"
                required
                class="block mt-1 w-full border-gray-300 rounded-md
                       focus:border-indigo-500 focus:ring-indigo-500"
            >
                <option value="">-- Pilih Bahagian --</option>
                @foreach ($bahagians as $b)
                    <option value="{{ $b->id }}"
                        {{ old('bahagian_id') == $b->id ? 'selected' : '' }}>
                        {{ $b->nama }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('bahagian_id')" class="mt-2" />
        </div>

        {{-- UNIT --}}
        <div class="mt-4">
            <x-input-label for="unit_id">
                Unit <span class="text-red-500">*</span>
            </x-input-label>
            <select
                id="unit_id"
                name="unit_id"
                required
                class="block mt-1 w-full border-gray-300 rounded-md
                       focus:border-indigo-500 focus:ring-indigo-500"
            >
                <option value="">-- Pilih Unit --</option>
            </select>
            <x-input-error :messages="$errors->get('unit_id')" class="mt-2" />
        </div>

        {{-- PASSWORD --}}
        <div class="mt-4">
            <x-input-label for="password">
                Kata Laluan <span class="text-red-500">*</span>
            </x-input-label>
            <x-text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required
                minlength="8"
                autocomplete="new-password"
                placeholder="Minimum 8 aksara"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- CONFIRM PASSWORD --}}
        <div class="mt-4">
            <x-input-label for="password_confirmation">
                Sahkan Kata Laluan <span class="text-red-500">*</span>
            </x-input-label>
            <x-text-input
                id="password_confirmation"
                class="block mt-1 w-full"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- ACTIONS --}}
        <div class="flex items-center justify-between mt-6">
            <a
                class="underline text-sm text-gray-600 hover:text-gray-900"
                href="{{ route('login') }}"
            >
                Sudah mempunyai akaun?
            </a>

            <x-primary-button>
                Daftar Akaun
            </x-primary-button>
        </div>
    </form>

    {{-- DEPENDENT DROPDOWN SCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const bahagianSelect = document.getElementById('bahagian_id');
            const unitSelect = document.getElementById('unit_id');

            bahagianSelect.addEventListener('change', function () {

                const bahagianID = this.value;
                unitSelect.innerHTML = '<option value="">-- Pilih Unit --</option>';

                if (!bahagianID) return;

                fetch(`/get-units/${bahagianID}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(unit => {
                            const option = document.createElement('option');
                            option.value = unit.id;
                            option.textContent = unit.nama;
                            unitSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Ralat mengambil unit:', error);
                    });
            });

        });
    </script>
</x-guest-layout>
