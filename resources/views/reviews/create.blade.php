<x-app-layout>
    <div class="max-w-2xl mx-auto py-10 px-4 sm:px-6 lg:px-8 pt-24">

        <div class="mb-8">
            <a href="{{ route('bookings.history') }}" class="text-sm font-bold text-slate-500 hover:text-slate-700 flex items-center gap-2 mb-4 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Riwayat
            </a>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Beri Ulasan</h1>
            <p class="text-sm text-slate-500 mt-2">Bagaimana pengalaman bermain Anda di <span class="font-bold text-slate-700">{{ $booking->field->venue->name ?? 'venue ini' }}</span>?</p>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden p-6 sm:p-8">

            @if(session('error'))
                <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl text-sm font-medium">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('reviews.store', $booking->id) }}" method="POST" x-data="{ rating: 0, hover: 0 }">
                @csrf

                <div class="mb-8 text-center bg-slate-50 border border-slate-100 rounded-2xl p-6">
                    <label class="block text-sm font-bold text-slate-700 mb-4 uppercase tracking-wider">Penilaian Anda <span class="text-rose-500">*</span></label>

                    <div class="flex items-center justify-center gap-2">
                        <template x-for="i in 5" :key="i">
                            <button type="button"
                                    x-on:click="rating = i"
                                    x-on:mouseover="hover = i"
                                    x-on:mouseleave="hover = 0"
                                    class="focus:outline-none transition-transform hover:scale-110"
                            >
                                <svg class="w-12 h-12 sm:w-14 sm:h-14 transition-colors duration-200"
                                     x-bind:class="(hover >= i || (!hover && rating >= i)) ? 'text-warning-400 drop-shadow-md' : 'text-slate-200'"
                                     fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </template>
                    </div>

                    <input type="hidden" name="rating" x-model="rating" required>

                    @error('rating')
                    <p class="mt-4 text-sm text-rose-500 font-bold bg-rose-50 inline-block px-3 py-1 rounded-md">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-8">
                    <label for="comment" class="block text-sm font-bold text-slate-700 mb-2">Ceritakan pengalaman Anda <span class="text-slate-400 font-normal">(Opsional)</span></label>
                    <textarea id="comment" name="comment" rows="4"
                              class="w-full rounded-xl border-slate-200 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-500/20 transition-colors p-4 text-sm"
                              placeholder="Fasilitasnya bagus, lapangannya bersih, pelayanannya ramah..."></textarea>
                    @error('comment')
                    <p class="mt-2 text-sm text-rose-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end pt-4 border-t border-slate-100">
                    <x-atoms.button type="primary" class="!px-8 !py-3.5 font-bold w-full sm:w-auto text-base shadow-lg" x-bind:disabled="rating === 0">
                        Kirim Ulasan
                    </x-atoms.button>
                </div>
                <p class="text-center sm:text-right text-xs text-slate-400 mt-3" x-show="rating === 0">Silakan pilih bintang terlebih dahulu</p>
            </form>

        </div>
    </div>
</x-app-layout>
