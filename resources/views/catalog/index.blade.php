@extends('layout.site')
@section('content')

<h1>Каталог товаров</h1>
<p>
    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque ducimus, eligendi
    exercitationem expedita, iure iusto laborum magnam qui quidem repellat similique
    tempora tempore ullam! Deserunt doloremque impedit quis repudiandae voluptas?
</p>
<h2>разделы каталога</h2>
<div class="row">
    @foreach($roots as $root)   
        @include('catalog.part.category',['root' => $root])
    @endforeach
</div>    

@endsection

