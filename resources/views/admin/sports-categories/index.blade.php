<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">
            Sports Categories
        </h1>

        <div class="mb-4">
            <a href="{{ route('sports-categories.create') }}"
                class="bg-blue-500 inline-block text-white px-4 py-2 rounded hover:bg-blue-600">
                + Add Category
            </a>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2">ID</th>
                        <th class="border p-2">Name</th>
                        <th class="border p-2">Status</th>
                        <th class="border p-2">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td class="border p-2">
                                {{ $category->id }}
                            </td>

                            <td class="border p-2">
                                {{ $category->name }}
                            </td>

                            <td class="border p-2">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </td>

                            <td class="border p-2">
                                <div class="flex gap-2">
                                    <a
                                    href="{{ route('sports-categories.edit', $category->id) }}"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded"
                                    >
                                    Edit
                                </a>
                                <form
                                action="{{ route('sports-categories.destroy', $category->id) }}"
                                method="POST"
                                onsubmit="return confirm('Delete this category?')"
                                >
                                @csrf
                                @method('DELETE')
                                
                                <button
                                type="submit"
                                class="bg-red-500 text-white px-3 py-1 rounded"
                                >
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="border p-2 text-center">
                                No categories found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>