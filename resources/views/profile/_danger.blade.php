<div class="bg-red-50 p-6 rounded-lg border-0 border-red-200">
    <p class="text-md text-red-700 mb-4">{{ __('profile.delete_account_warning_intro') }}</p>

    <button
        @click="showDeleteModal = true"
        class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition"
    >
        <i class="bi bi-person-x mr-2"></i> {{ __('profile.delete_my_account') }}
    </button>

    <div x-show="showDeleteModal" x-cloak
         class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-60 z-50 p-4"
         @click.away="showDeleteModal = false">
        <div class="bg-white rounded-xl shadow-2xl max-w-sm w-full p-8">
            <h3 class="text-xl font-bold text-red-700 mb-4">{{ __('profile.confirm_account_deletion') }}</h3>
            <p class="mb-6 text-gray-600">
                {{ __('profile.delete_account_warning_detail') }}
            </p>

            <div class="flex justify-end space-x-3">
                <button @click="showDeleteModal = false" type="button" class="px-5 py-2 bg-gray-200 rounded-lg text-gray-700 hover:bg-gray-300 transition">
                    {{ __('content.cancel') }}
                </button>
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-5 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        {{ __('profile.delete_account_confirm') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
