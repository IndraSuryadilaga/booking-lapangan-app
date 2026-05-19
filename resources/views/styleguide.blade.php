<x-layout title="Design System Styleguide">
    <section class="space-y-8">
        <h1 class="text-3xl font-bold">Base UI Components</h1>

        <div class="space-y-4">
            <h2 class="text-xl font-semibold">Buttons</h2>
            <div class="flex gap-4">
                <x-ui.button variant="primary">Primary Button</x-ui.button>
                <x-ui.button variant="secondary">Secondary Button</x-ui.button>
                <x-ui.button variant="outline">Outline Button</x-ui.button>
            </div>
        </div>

        <div class="space-y-4">
            <h2 class="text-xl font-semibold">Cards</h2>
            <x-ui.card class="max-w-sm p-6">
                <h3 class="font-bold text-lg">Nama Lapangan</h3>
                <p class="text-slate-600">Deskripsi singkat lapangan olahraga.</p>
            </x-ui.card>
        </div>

        <div class="space-y-4">
            <h2 class="text-xl font-semibold">Status Badges</h2>
            <div class="flex gap-3">
                <x-ui.badge variant="success">Tersedia</x-ui.badge>
                <x-ui.badge variant="danger">Penuh</x-ui.badge>
                <x-ui.badge variant="warning">Pending</x-ui.badge>
                <x-ui.badge variant="info">Booking</x-ui.badge>
            </div>
        </div>
    </section>
</x-layout>
