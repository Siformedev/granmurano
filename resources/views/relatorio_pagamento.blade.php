@foreach ($result as $item)
    {{$item->invoice_id}} - {{$item->status}} <br>
@endforeach