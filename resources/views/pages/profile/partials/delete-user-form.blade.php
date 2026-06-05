<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-atoms.button
        type="danger"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</x-atoms.button>

    <x-organisms.modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-atoms.input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-atoms.input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                    :error="$errors->userDeletion->has('password')"
                    :messages="$errors->userDeletion->get('password')"
                />
            </div>

            <div class="mt-6 flex justify-end">
                <x-atoms.button type="secondary" x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-atoms.button>

                <x-atoms.button type="danger" class="ms-3">
                    {{ __('Delete Account') }}
                </x-atoms.button>
            </div>
        </form>
    </x-organisms.modal>
</section>
