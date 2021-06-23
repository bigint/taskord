@foreach ($products as $product)
    {{ 'https://taskord.com/product/' . $product->slug }}
    {{ 'https://taskord.com/product/' . $product->slug . '/pending' }}
    {{ 'https://taskord.com/product/' . $product->slug . '/updates' }}
    {{ 'https://taskord.com/product/' . $product->slug . '/subscribers' }}
@endforeach
