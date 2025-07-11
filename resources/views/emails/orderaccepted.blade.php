@component('mail::message')
# Reservasi Anda telah Disetujui!
Reservasi anda telah disetujui oleh Admin.
langkah selanjutnya adalah nelakukan pembayaran melalui transfer melalui ATM ke rekening :

## BCA xxxxxxxxxx a/n CekrekinAja
## BRI xxxxxxxxxx a/n CekrekinAja
## Mandiri xxxxxx a/n CekrekinAja
## Jumlah Pembayaran : @money($payment->total)

setelah pembayaran, silakan upload bukti bayar pada website

# Detail Reservasi
<b>Nama : {{$payment->user->name}}</b><br>
<b>No Invoice : {{ $payment->no_invoice }}</b> <br>
<b>Tanggal Pengambilan : {{ date('d M Y H:i', strtotime($payment->order->first()->starts)) }}</b>
@component('mail::table')
| Alat       | Durasi         | Harga  |
| ------------- |:-------------:| --------:|
@foreach ($payment->order as $item)
| {{$item->alat->nama_alat}} | {{ $item->durasi }} Jam | @money($item->harga) |
@endforeach
@endcomponent

Thanks,<br>
{{ config('Rental Kamera Online Amikom') }}
@endcomponent
