@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4">Tulis Ulasan</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('reviews.store', $booking) }}">
        @csrf

        <div class="mb-4">
            <x-atoms.input-label for="rating">Rating</x-atoms.input-label>
            <x-atoms.select name="rating" id="rating" class="mt-1 block w-full">
                <option value="">-- Pilih rating --</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </x-atoms.select>
            @error('rating')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <x-atoms.input-label for="comment">Komentar (opsional)</x-atoms.input-label>
            <x-atoms.input-textarea name="comment" id="comment" class="mt-1 block w-full" rows="5">{{ old('comment') }}</x-atoms.input-textarea>
            @error('comment')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center">
            <x-atoms.button type="submit">Kirim Ulasan</x-atoms.button>
            <a href="{{ url()->previous() }}" class="ml-4 text-sm text-gray-600">Batal</a>
        </div>
    </form>
</div>
@endsection
