@extends('layouts.student')

@push('scripts')
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
@endpush

@section('content')
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Selesaikan Pembayaran</h1>
        <div class="mb-4">
            <p class="text-gray-600">Paket: <span class="font-semibold">{{ $package->name }}</span></p>
            <p class="text-gray-600">Harga: <span class="font-semibold">Rp{{ number_format($package->price, 0, ',', '.') }}</span></p>
        </div>
        <button id="pay-button" class="w-full bg-green-500 text-white font-bold py-3 px-6 rounded-lg hover:bg-green-600 transition-colors duration-300">
            Bayar Sekarang
        </button>
    </div>

    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    /* You may add your own implementation here */
                    // alert("payment success!"); 
                    window.location.href = '{{ route("siswa.payment.success") }}';
                },
                onPending: function(result){
                    /* You may add your own implementation here */
                    alert("wating your payment!"); console.log(result);
                },
                onError: function(result){
                    /* You may add your own implementation here */
                    alert("payment failed!"); console.log(result);
                },
                onClose: function(){
                    /* You may add your own implementation here */
                    alert('you closed the popup without finishing the payment');
                }
            });
        });
    </script>
@endsection