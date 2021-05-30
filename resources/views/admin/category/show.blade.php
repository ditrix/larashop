@extends('layout.admin', ['title' => 'Просмотр категории'])

@section('content')
    <h1>Просмотр категории</h1>
    <div class="row">
        <div class="col-md-6">
            <p><strong>Название:</strong> {{ $category->name }}</p>
            <p><strong>ЧПУ (англ):</strong> {{ $category->slug }}</p>
            <p><strong>Краткое описание</strong></p>
            @isset($category->content)
                <p>{{ $category->content }}</p>
            @else
                <p>Описание отсутствует</p>
            @endisset
        </div>
        <div class="col-md-6">
            @php
                if ($category->image) {
                    $url = Storage::disk('public')->url('catalog/category/image/' . $category->image);
                    // НЕ БАГ А ФИЧА ))))  вместо localhost тупо прописываем  http://127.0.0.1:8000/
                    $url = "http://127.0.0.1:8000/storage/catalog/category/image/".$category->image;
                } else {
                    // $url = url('storage/catalog/category/image/default.jpg');
                    $url = "https://via.placeholder.com/600x200";
                }
            @endphp
            <img src="{{ $url }}" alt="" class="img-fluid">
        </div>
    </div>
    @if ($category->children->count())
        <p><strong>Дочерние категории</strong></p>
        <table class="table table-bordered">
            <tr>
                <th>№</th>
                <th width="45%">Наименование</th>
                <th width="45%">ЧПУ (англ)</th>
                <th><i class="fas fa-edit"></i></th>
                <th><i class="fas fa-trash-alt"></i></th>
            </tr>
            @foreach ($category->children as $child)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <a href="{{ route('admin.category.show', ['category' => $child->id]) }}">
                            {{ $child->name }}
                        </a>
                    </td>
                    <td>{{ $child->slug }}</td>
                    <td>
                        <a href="{{ route('admin.category.edit', ['category' => $child->id]) }}">
                            <i class="far fa-edit"></i>
                        </a>
                    </td>
                    <td>
                        <form action="{{ route('admin.category.destroy', ['category' => $child->id]) }}"
                              method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="m-0 p-0 border-0 bg-transparent">
                                <i class="far fa-trash-alt text-danger"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    @else
        <p>Нет дочерних категорий</p>
    @endif
    <div class="row">
        <div class="col-6">
            <form method="post" action="{{ route('admin.category.edit', ['category' => $category->id]) }}">
                @csrf
                @method('GET')
                <button type="submit" class="btn btn-success">
                    Редактировать категорию
                </button> 
            </form>
        </div>
        <div class="col-6">
            <form method="post"
                action="{{ route('admin.category.destroy', ['category' => $category->id]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    Удалить категорию
                </button>
            </form>
        </div>
    </div>    
@endsection