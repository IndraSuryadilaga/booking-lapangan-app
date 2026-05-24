<x-layout title="Design System Styleguide">
    <section class="space-y-8">
        <h1 class="text-3xl font-bold">Base UI Components</h1>

        <div class="space-y-4">
            <h2 class="text-xl font-semibold">Buttons</h2>
            <div class="flex gap-4">
                <x-atoms.button variant="primary">Primary Button</x-atoms.button>
                <x-atoms.button variant="secondary">Secondary Button</x-atoms.button>
                <x-atoms.button variant="outline">Outline Button</x-atoms.button>
            </div>
        </div>

        <div class="space-y-4">
            <h2 class="text-xl font-semibold">Cards</h2>
            <x-molecules.card class="max-w-sm p-6">
                <h3 class="font-bold text-lg">Nama Lapangan</h3>
                <p class="text-slate-600">Deskripsi singkat lapangan olahraga.</p>
            </x-molecules.card>
        </div>

        <div class="space-y-4">
            <h2 class="text-xl font-semibold">Status Badges</h2>
            <div class="flex gap-3">
                <x-atoms.badge variant="success">Tersedia</x-atoms.badge>
                <x-atoms.badge variant="danger">Penuh</x-atoms.badge>
                <x-atoms.badge variant="warning">Pending</x-atoms.badge>
                <x-atoms.badge variant="info">Booking</x-atoms.badge>
            </div>
        </div>
    </section>
</x-layout>
