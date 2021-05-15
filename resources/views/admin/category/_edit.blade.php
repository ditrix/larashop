@extends('layout.admin')

@section('content')
    <h1>Редактирование категории</h1>
    <form method="post" enctype="multipart/form-data"
          action="{{ route('admin.category.update', ['category' => $category->id]) }}">
        @method('PUT')
        @csrf
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Наименование"
                   required maxlength="100" value="{{ old('name') ?? $category->name }}">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="title" placeholder="ЧПУ (на англ.)"
                   required maxlength="100" value="{{ old('slug') ?? $category->slug }}">
        </div>
        <div class="form-group">
            <select name="parent_id" class="form-control" title="Родитель">
                <option value="0">Без родителя</option>
                @if (count($parents))
                    @include('admin.category.part.branch', ['items' => $parents, 'level' => -1])
                @endif
            </select>
        </div>
        <div class="form-group">
            <textarea class="form-control" name="content" placeholder="Краткое описание"
                      maxlength="200" rows="3">{{ old('content') ?? $category->content }}</textarea>
        </div>
        <div class="form-group">
            <input type="file" class="form-control-file" name="image" accept="image/png, image/jpeg">
        </div>
        @isset($category->image)
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" name="remove" id="remove">
                <label class="form-check-label" for="remove">Удалить загруженное изображение</label>
            </div>
        @endisset
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
@endsection