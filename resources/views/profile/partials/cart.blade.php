<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Your Cart') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('This is your cart') }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        @if(count($carts) == 0)
            <h2 class="text-center text-lg font-semibold my-4">No Cart</h2>
        @else
        <div class="grid grid-cols-1 gap-4">
            @foreach($carts as $data)
            <div
                class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100">
                <div class="bg-center bg-no-repeat bg-contain rounded-t-lg"
                    style="background-image: url('http://127.0.0.1:8080/storage/product/{{ $data['product']['photo'] }}')">
                    <img class="invisible w-1/12 h-40" src="{{ asset('assets/background.png') }}" alt="" />
                </div>
                <div class="flex flex-col justify-between p-4 leading-normal">
                    <h5 class="mb-2 text-lg font-bold tracking-tight text-gray-900">{{ $data['product']['name'] }}</h5>
                    <div class="flex items-center gap-x-5 font-semibold text-sm">
                        <div class="flex items-center gap-x-8">
                            <p>
                                Quantity:
                            </p>
                            <p>
                                {{ $data['qty'] }}
                            </p>
                        </div>
                        <div class="flex items-center gap-x-8">
                            <p>
                                Total Price:
                            </p>
                            <p>
                                Rp. {{ $data['totalPrice'] }}
                            </p>
                        </div>
                        <button data-modal-target="deleteCart-{{ $data['id'] }}"
                            data-modal-toggle="deleteCart-{{ $data['id'] }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div id="deleteCart-{{ $data['id'] }}" tabindex="-1"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow">
                        <button type="button"
                            class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                            data-modal-hide="deleteCart-{{ $data['id'] }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <div class="p-4 md:p-5 text-center">
                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <h3 class="mb-5 text-lg font-normal text-gray-500">Are you sure you want
                                to delete this cart?</h3>
                            <form action="{{ route('deleteCart') }}" method="post">
                                @csrf
                                <input type="hidden" name="cartId" value="{{ $data['id'] }}">
                                <button type="submit"
                                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                    Yes, I'm sure
                                </button>
                                <button data-modal-hide="deleteCart-{{ $data['id'] }}" type="button"
                                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">No,
                                    cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @endforeach
        </div>
        @endif
    </div>
</section>
