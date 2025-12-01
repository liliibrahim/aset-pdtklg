<x-guest-layout> 
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text"
                name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email"
                name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text"
                name="phone" :value="old('phone')" required />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Bahagian -->
        <div class="mt-4">
            <x-input-label for="bahagian_id" :value="__('Bahagian')" />
            <select id="bahagian_id" name="bahagian_id"
                class="block mt-1 w-full border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">-- Pilih Bahagian --</option>
                @foreach ($bahagians as $b)
                    <option value="{{ $b->id }}">{{ $b->nama }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('bahagian_id')" class="mt-2" />
        </div>

        <!-- Unit -->
        <div class="mt-4">
            <x-input-label for="unit_id" :value="__('Unit')" />
            <select id="unit_id" name="unit_id"
                class="block mt-1 w-full border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">-- Pilih Unit --</option>
            </select>
            <x-input-error :messages="$errors->get('unit_id')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md
                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Dependent Dropdown Script -->
    <script>
        document.getElementById('bahagian_id').addEventListener('change', function () {
            let bahagianID = this.value;

            fetch('/get-units/' + bahagianID)
                .then(response => response.json())
                .then(data => {
                    let unitSelect = document.getElementById('unit_id');
                    unitSelect.innerHTML = '<option value="">-- Pilih Unit --</option>';

                    data.forEach(function (item) {
                        unitSelect.innerHTML += `<option value="${item.id}">${item.nama}</option>`;
                    });
                });
        });
    </script>

</x-guest-layout>
