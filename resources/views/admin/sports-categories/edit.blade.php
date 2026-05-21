<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">
            Edit Sports Category
        </h1>

        <div class="bg-white rounded-lg shadow p-6 max-w-xl">
            <form action="{{ route('sports-categories.update', $category->id) }}" method="POST">
                @csrf
                <input type="hidden" name="_method" value="PUT">

                <div class="mb-4">
                    <label class="block mb-2 font-medium">
                        Category Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ $category->name }}"
                        class="w-full border rounded px-3 py-2"
                    >
                </div>

                <div class="mb-4">
                    <label class="flex items-center gap-2">
                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            {{ $category->is_active ? 'checked' : '' }}
                        >
                        Active
                    </label>
                </div>

                <button
                    type="submit"
                    class="bg-yellow-500 text-white px-4 py-2 rounded"
                >
                    Update Category
                </button>
            </form>
        </div>
    </div>
</x-app-layout>