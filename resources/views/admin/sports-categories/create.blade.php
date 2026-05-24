<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">
            Add Sports Category
        </h1>

        <div class="bg-white rounded-lg shadow p-6 max-w-lg">
            <form method="POST" action="{{ route('sports-categories.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block mb-2 font-medium">
                        Category Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="w-full border rounded px-3 py-2"
                        placeholder="Enter category name"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="is_active">
                        Active
                    </label>
                </div>

                <button
                    type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded"
                >
                    Save Category
                </button>
            </form>
        </div>
    </div>
</x-app-layout>