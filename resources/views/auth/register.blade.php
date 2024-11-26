<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Personal ID (NIM) -->
        <div>
            <x-input-label for="personal_id" :value="__('NIM')" />
            <x-text-input id="personal_id" class="block mt-1 w-full" type="text" name="personal_id" :value="old('personal_id')" required autofocus />
            <!-- Display error messages here -->
            <x-input-error :messages="$errors->get('personal_id')" class="mt-2" />
        </div>

        <!-- Fetch Data Button -->
        <div class="mt-4">
            <button type="button" id="fetchStudentData" class="bg-blue-500 text-white py-2 px-4 rounded">
                {{ __('Fetch Data') }}
            </button>
        </div>

        <!-- Display Student Info -->
        <div id="studentInfo" class="mt-4 hidden">
            <p>{{ __('Name: ') }}<span id="studentName"></span></p>
            <p>{{ __('Gender: ') }}<span id="studentGender"></span></p>
            <p>{{ __('Angkatan: ') }}<span id="studentAngkatan"></span></p>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <!-- JavaScript for Fetching Student Data -->
    <script>
        document.getElementById('fetchStudentData').addEventListener('click', function () {
            const personalId = document.getElementById('personal_id').value.trim();

            // Show alert if NIM is empty
            if (!personalId) {
                alert('Please enter your NIM.');
                return;
            }

            // Fetch student data using the personal ID (NIM)
            fetch(`/api/students/${personalId}`)
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        throw new Error(data.message);
                    }

                    // Successfully retrieved data, show the information
                    if (data.data) {
                        document.getElementById('studentName').textContent = data.data.name;
                        document.getElementById('studentGender').textContent = data.data.gender;
                        document.getElementById('studentAngkatan').textContent = data.data.angkatan;
                        document.getElementById('studentInfo').classList.remove('hidden');
                    }
                })
                .catch(error => {
                    // Display alert if there is an error (e.g., data not found)
                    console.error('Error fetching student data:', error);
                    alert('Student data not found. Please check the NIM and try again.');
                });
        });
    </script>
</x-guest-layout>
