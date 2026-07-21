@extends('layouts.app')
@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 text-xs sm:text-sm text-gray-500 mb-6 sm:mb-8 flex-wrap">
        <a href="{{ route('shop.index') }}" class="hover:text-indigo-600">{{ __('shop.browse_shop') }}</a>
        <span>/</span>
        @if($product->category)
        <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}" class="hover:text-indigo-600">{{ $product->category->name }}</a>
        <span>/</span>
        @endif
        <span class="text-gray-900 font-medium truncate max-w-[200px]">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-12">
        {{-- Product Image --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            @if($product->image_url)
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-64 sm:h-80 lg:h-96 object-cover">
            @else
            <div class="w-full h-64 sm:h-80 lg:h-96 bg-gray-100 flex items-center justify-center">
                <svg class="w-16 h-16 sm:w-24 sm:h-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            @endif
        </div>

        {{-- Product Details --}}
        <div class="flex flex-col">
            @if($product->category)
            <span class="inline-block bg-indigo-100 text-indigo-700 text-xs font-semibold px-3 py-1 rounded-full mb-3 w-fit">{{ $product->category->name }}</span>
            @endif

            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2 sm:mb-3">{{ $product->name }}</h1>

            {{-- Rating summary --}}
            @if($reviews->isNotEmpty())
            <div class="flex items-center gap-2 mb-3">
                <div class="flex text-yellow-400 text-lg">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= round($avgRating))
                            <span>★</span>
                        @else
                            <span class="text-gray-300">★</span>
                        @endif
                    @endfor
                </div>
                <span class="text-sm font-semibold text-gray-700">{{ number_format($avgRating, 1) }}</span>
                <span class="text-sm text-gray-400">({{ $reviews->count() }} {{ __('shop.customer_reviews') }})</span>
            </div>
            @endif

            <p class="text-3xl sm:text-4xl font-extrabold text-indigo-600 mb-3 sm:mb-4">${{ number_format($product->price, 2) }}</p>

            {{-- Stock Indicator --}}
            @if($product->isInStock())
            <div class="flex items-center gap-2 mb-4 sm:mb-6">
                <span class="w-2.5 h-2.5 bg-green-400 rounded-full animate-pulse flex-shrink-0"></span>
                <span class="text-sm text-green-700 font-medium">{{ __('shop.in_stock') }} — {{ $product->stock_quantity }} {{ __('shop.units_available') }}</span>
            </div>
            @else
            <div class="flex items-center gap-2 mb-4 sm:mb-6">
                <span class="w-2.5 h-2.5 bg-red-400 rounded-full flex-shrink-0"></span>
                <span class="text-sm text-red-600 font-medium">{{ __('shop.out_of_stock') }}</span>
            </div>
            @endif

            <p class="text-gray-600 leading-relaxed mb-6 sm:mb-8 text-sm sm:text-base">{{ $product->description }}</p>

            {{-- Add to Cart + Wishlist --}}
            <div class="flex flex-col gap-3">
                @if($product->isInStock())
                <form action="{{ route('cart.add', $product) }}" method="POST">
                    @csrf
                    <div class="flex gap-3 items-center">
                        <div class="flex items-center border border-gray-300 rounded-xl overflow-hidden flex-shrink-0">
                            <button type="button" onclick="adjustQty(-1)" class="px-3 sm:px-4 py-3 text-gray-600 hover:bg-gray-50 font-semibold text-base">−</button>
                            <input type="number" name="quantity" id="qty" value="1" min="1" max="{{ $product->stock_quantity }}"
                                   class="w-12 sm:w-16 text-center py-3 border-x border-gray-300 text-sm font-semibold focus:outline-none">
                            <button type="button" onclick="adjustQty(1)" class="px-3 sm:px-4 py-3 text-gray-600 hover:bg-gray-50 font-semibold text-base">+</button>
                        </div>
                        <button type="submit" class="flex-1 bg-indigo-600 text-white py-3 px-4 sm:px-6 rounded-xl font-semibold hover:bg-indigo-700 active:scale-95 transition-all duration-150 flex items-center justify-center gap-2 text-sm sm:text-base">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            {{ __('shop.add_to_cart') }}
                        </button>
                    </div>
                </form>
                @else
                <button disabled class="w-full bg-gray-200 text-gray-500 py-3 px-6 rounded-xl font-semibold cursor-not-allowed text-sm sm:text-base">
                    {{ __('shop.out_of_stock') }} — {{ __('shop.check_back_soon') }}
                </button>
                @endif

                {{-- Wishlist toggle --}}
                @auth
                <form action="{{ route('wishlist.toggle', $product) }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 py-3 px-6 rounded-xl border-2 font-semibold text-sm sm:text-base transition-all duration-150
                                   {{ $inWishlist ? 'border-red-400 text-red-500 bg-red-50 hover:bg-red-100' : 'border-gray-300 text-gray-600 hover:border-red-300 hover:text-red-500 hover:bg-red-50' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="{{ $inWishlist ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        {{ $inWishlist ? __('shop.remove_from_wishlist') : __('shop.add_to_wishlist') }}
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}"
                   class="w-full flex items-center justify-center gap-2 py-3 px-6 rounded-xl border-2 border-gray-300 text-gray-500 font-semibold text-sm hover:border-red-300 hover:text-red-400 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    {{ __('shop.add_to_wishlist') }}
                </a>
                @endauth
            </div>

            {{-- Trust Badges --}}
            <div class="mt-6 sm:mt-8 grid grid-cols-3 gap-3 sm:gap-4 border-t border-gray-100 pt-5 sm:pt-6">
                <div class="text-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-indigo-500 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <p class="text-xs text-gray-500 font-medium">{{ __('shop.secure') }}</p>
                </div>
                <div class="text-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-indigo-500 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    <p class="text-xs text-gray-500 font-medium">{{ __('shop.free_returns') }}</p>
                </div>
                <div class="text-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-indigo-500 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <p class="text-xs text-gray-500 font-medium">{{ __('shop.invoice') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Reviews Section ─────────────────────────────────────────────── --}}
    <div class="mt-12 sm:mt-16">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900">{{ __('shop.customer_reviews') }}</h2>
            @if($reviews->isNotEmpty())
            <div class="flex items-center gap-2">
                <div class="flex text-yellow-400 text-xl">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="{{ $i <= round($avgRating) ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                    @endfor
                </div>
                <span class="font-bold text-gray-800 text-lg">{{ number_format($avgRating, 1) }}</span>
                <span class="text-gray-400 text-sm">/5</span>
            </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Write / edit review form --}}
            @auth
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 sm:p-6">
                    <h3 class="font-semibold text-gray-900 mb-4">
                        {{ $userReview ? __('shop.your_review') : __('shop.write_a_review') }}
                    </h3>
                    <form action="{{ route('reviews.store', $product) }}" method="POST">
                        @csrf
                        {{-- Star picker --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('shop.your_rating') }}</label>
                            <div class="flex gap-1" id="star-picker">
                                @for($s = 1; $s <= 5; $s++)
                                <label class="cursor-pointer">
                                    <input type="radio" name="rating" value="{{ $s }}" class="sr-only"
                                           {{ $userReview && $userReview->rating == $s ? 'checked' : '' }}>
                                    <svg class="w-8 h-8 star-icon transition-colors {{ $userReview && $userReview->rating >= $s ? 'text-yellow-400' : 'text-gray-300' }}"
                                         fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                </label>
                                @endfor
                            </div>
                            @error('rating')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Comment --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('shop.your_comment') }}</label>
                            <textarea name="comment" rows="4"
                                      class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none"
                                      placeholder="{{ __('shop.your_comment') }}">{{ $userReview?->comment }}</textarea>
                        </div>

                        <button type="submit"
                                class="w-full bg-indigo-600 text-white py-2.5 rounded-xl font-semibold text-sm hover:bg-indigo-700 transition-colors">
                            {{ $userReview ? __('shop.update_review') : __('shop.submit_review') }}
                        </button>
                    </form>

                    {{-- Delete own review --}}
                    @if($userReview)
                    <form action="{{ route('reviews.destroy', $userReview) }}" method="POST" class="mt-3">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete your review?')"
                                class="w-full text-red-500 hover:text-red-700 text-sm font-medium py-2">
                            {{ __('shop.delete_review') }}
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @endauth

            {{-- Review list --}}
            <div class="{{ auth()->check() ? 'lg:col-span-2' : 'lg:col-span-3' }}">
                @if($reviews->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 text-center text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <p class="font-medium">{{ __('shop.no_reviews_yet') }}</p>
                </div>
                @else
                <div class="space-y-4">
                    @foreach($reviews as $review)
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-5 {{ $review->user_id === auth()->id() ? 'border-indigo-200 bg-indigo-50/30' : '' }}">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-gradient-to-br from-indigo-500 to-purple-600 text-white rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 text-sm">
                                        {{ $review->user->name }}
                                        @if($review->user_id === auth()->id())
                                        <span class="text-xs text-indigo-600 font-normal ms-1">({{ __('shop.your_review') }})</span>
                                        @endif
                                    </p>
                                    <div class="flex items-center gap-1.5 mt-0.5">
                                        <div class="flex text-yellow-400 text-sm">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span class="{{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                            @endfor
                                        </div>
                                        <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($review->comment)
                        <p class="text-gray-600 text-sm mt-3 leading-relaxed">{{ $review->comment }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Related Products --}}
    @if($related->isNotEmpty())
    <div class="mt-12 sm:mt-16">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-5 sm:mb-6">{{ __('shop.related_products') }}</h2>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            @foreach($related as $rp)
            <a href="{{ route('shop.show', $rp) }}" class="bg-white rounded-xl border border-gray-100 overflow-hidden hover:shadow-md transition-shadow group">
                <div class="h-32 sm:h-40 bg-gray-100 overflow-hidden">
                    @if($rp->image_url)
                    <img src="{{ $rp->image_url }}" alt="{{ $rp->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @endif
                </div>
                <div class="p-3 sm:p-4">
                    <p class="text-xs sm:text-sm font-semibold text-gray-900 line-clamp-2 leading-tight">{{ $rp->name }}</p>
                    <p class="text-sm font-bold text-indigo-600 mt-1">${{ number_format($rp->price, 2) }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function adjustQty(delta) {
    const el = document.getElementById('qty');
    const max = parseInt(el.max);
    const newVal = Math.min(Math.max(1, parseInt(el.value) + delta), max);
    el.value = newVal;
}

// Interactive star picker
document.addEventListener('DOMContentLoaded', function () {
    const labels = document.querySelectorAll('#star-picker label');
    labels.forEach((label, idx) => {
        label.addEventListener('mouseenter', () => {
            labels.forEach((l, i) => {
                l.querySelector('svg').classList.toggle('text-yellow-400', i <= idx);
                l.querySelector('svg').classList.toggle('text-gray-300', i > idx);
            });
        });
        label.addEventListener('click', () => {
            labels.forEach((l, i) => {
                l.querySelector('svg').classList.toggle('text-yellow-400', i <= idx);
                l.querySelector('svg').classList.toggle('text-gray-300', i > idx);
            });
        });
    });
    const picker = document.getElementById('star-picker');
    if (picker) {
        picker.addEventListener('mouseleave', () => {
            const checked = picker.querySelector('input[type=radio]:checked');
            const checkedIdx = checked ? parseInt(checked.value) - 1 : -1;
            labels.forEach((l, i) => {
                l.querySelector('svg').classList.toggle('text-yellow-400', i <= checkedIdx);
                l.querySelector('svg').classList.toggle('text-gray-300', i > checkedIdx);
            });
        });
    }
});
</script>
@endpush
