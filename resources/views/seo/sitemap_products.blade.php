@foreach ($products as $product)
{{ 'https://taskord.com/product/'.$product->slug }}
@endforeach
