<x-app-layout title="Design System Styleguide">
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 space-y-16">

        <div class="border-b border-neutral-200 dark:border-neutral-700 pb-5">
            <h1 class="text-3xl font-extrabold text-neutral-900 dark:text-white tracking-tight">Base UI Components</h1>
            <p class="mt-2 text-sm text-neutral-500 dark:text-neutral-400">Kumpulan komponen UI dasar (Atoms & Molecules) untuk aplikasi.</p>
        </div>

        <section>
            <h2 class="text-xl font-bold text-neutral-800 dark:text-neutral-100 mb-4 border-l-4 border-primary-500 pl-3">Buttons</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
                    <h3 class="text-xs font-semibold text-neutral-500 mb-4 uppercase tracking-wider">Light Mode</h3>
                    <div class="flex flex-wrap gap-4 items-center">
                        <x-atoms.button type="primary">Primary</x-atoms.button>
                        <x-atoms.button type="secondary">Secondary</x-atoms.button>
                        <x-atoms.button type="danger">Destructive</x-atoms.button>
                        <x-atoms.button type="warning">Warning</x-atoms.button>
                        <x-atoms.button type="text">Text</x-atoms.button>
                    </div>
                </div>

                <div class="dark bg-neutral-800 border border-neutral-700 rounded-xl p-6 shadow-sm">
                    <h3 class="text-xs font-semibold text-neutral-400 mb-4 uppercase tracking-wider">Dark Mode</h3>
                    <div class="flex flex-wrap gap-4 items-center">
                        <x-atoms.button type="primary">Primary</x-atoms.button>
                        <x-atoms.button type="secondary">Secondary</x-atoms.button>
                        <x-atoms.button type="danger">Destructive</x-atoms.button>
                        <x-atoms.button type="warning">Warning</x-atoms.button>
                        <x-atoms.button type="text">Text</x-atoms.button>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <h2 class="text-xl font-bold text-neutral-800 dark:text-neutral-100 mb-4 border-l-4 border-primary-500 pl-3">Venue Cards</h2>
            <div class="space-y-6">
                <div class="bg-neutral-50 border border-slate-200 rounded-xl p-6">
                    <h3 class="text-xs font-semibold text-neutral-500 mb-4 uppercase tracking-wider">Light Mode</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <x-molecules.cards.venue
                            image="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            name="ASATU ARENA CIKINI"
                            rating="4.8"
                            sport="Mini Soccer"
                            location="Jakarta Pusat"
                            price="1650000"
                            url="/venue/asatu-arena-cikini"
                        />
                        <x-molecules.cards.venue
                            image="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            name="Gelora Bung Karno Indoor"
                            rating="4.9"
                            sport="Basket"
                            location="Jakarta Selatan"
                            price="2500000"
                        />
                    </div>
                </div>

                <div class="dark bg-neutral-900 border border-neutral-800 rounded-xl p-6">
                    <h3 class="text-xs font-semibold text-neutral-400 mb-4 uppercase tracking-wider">Dark Mode</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <x-molecules.cards.venue
                            image="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            name="ASATU ARENA CIKINI"
                            rating="4.8"
                            sport="Mini Soccer"
                            location="Jakarta Pusat"
                            price="1650000"
                            url="/venue/asatu-arena-cikini"
                        />
                        <x-molecules.cards.venue
                            image="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            name="Gelora Bung Karno Indoor"
                            rating="4.9"
                            sport="Basket"
                            location="Jakarta Selatan"
                            price="2500000"
                        />
                    </div>
                </div>
            </div>
        </section>

        <section>
            <h2 class="text-xl font-bold text-neutral-800 dark:text-neutral-100 mb-4 border-l-4 border-primary-500 pl-3">Court Cards</h2>
            @php
                $dummySchedules = [
                    ['time' => '19:00 - 20:00', 'status' => 'booked', 'price' => 150000],
                    ['time' => '20:00 - 21:00', 'status' => 'booked', 'price' => 150000],
                    ['time' => '21:00 - 22:00', 'status' => 'available', 'price' => 175000],
                    ['time' => '22:00 - 23:00', 'status' => 'booked', 'price' => 150000],
                    ['time' => '23:00 - 00:00', 'status' => 'available', 'price' => 120000],
                ];
            @endphp

            <div class="gap-6">
                <div class="bg-neutral-50 border border-slate-200 rounded-xl p-6">
                    <h3 class="text-xs font-semibold text-neutral-500 mb-4 uppercase tracking-wider">Light Mode</h3>
                    <x-molecules.cards.court
                        image="https://images.unsplash.com/photo-1554068865-24cecd4e34b8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                        name="Court A (blue)"
                        description="Lapangan A dengan karpet berwarna Biru"
                        sport="Padel"
                        type="Indoor"
                        material="Rumput Sintetis"
                        :schedules="$dummySchedules"
                    />
                </div>

                <div class="dark bg-neutral-900 border border-neutral-800 rounded-xl p-6">
                    <h3 class="text-xs font-semibold text-neutral-400 mb-4 uppercase tracking-wider">Dark Mode</h3>
                    <x-molecules.cards.court
                        image="https://images.unsplash.com/photo-1554068865-24cecd4e34b8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                        name="Court A (blue)"
                        description="Lapangan A dengan karpet berwarna Biru"
                        sport="Padel"
                        type="Indoor"
                        material="Rumput Sintetis"
                        :schedules="$dummySchedules"
                    />
                </div>
            </div>
        </section>

        <section>
            <h2 class="text-xl font-bold text-neutral-800 dark:text-neutral-100 mb-4 border-l-4 border-primary-500 pl-3">Status Badges</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
                    <h3 class="text-xs font-semibold text-neutral-500 mb-4 uppercase tracking-wider">Light Mode</h3>
                    <div class="flex flex-wrap gap-3">
                        <x-atoms.badge variant="success">Tersedia</x-atoms.badge>
                        <x-atoms.badge variant="danger">Penuh</x-atoms.badge>
                        <x-atoms.badge variant="warning">Pending</x-atoms.badge>
                        <x-atoms.badge variant="info">Booking</x-atoms.badge>
                    </div>
                </div>

                <div class="dark bg-neutral-800 border border-neutral-700 rounded-xl p-6 shadow-sm">
                    <h3 class="text-xs font-semibold text-neutral-400 mb-4 uppercase tracking-wider">Dark Mode</h3>
                    <div class="flex flex-wrap gap-3">
                        <x-atoms.badge variant="success">Tersedia</x-atoms.badge>
                        <x-atoms.badge variant="danger">Penuh</x-atoms.badge>
                        <x-atoms.badge variant="warning">Pending</x-atoms.badge>
                        <x-atoms.badge variant="info">Booking</x-atoms.badge>
                    </div>
                </div>
            </div>
        </section>

    </div>
</x-app-layout>
