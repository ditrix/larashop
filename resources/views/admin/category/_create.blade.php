@extends('layout.admin')

@section('content')
    <h1>Создание новой категории</h1>
    <form method="post" action="{{ route('admin.category.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Наименование"
                   required maxlength="100" value="{{ old('name') ?? '' }}">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="slug" placeholder="ЧПУ (на англ.)"
                   required maxlength="100" value="{{ old('slug') ?? '' }}">
        </div>
        <div class="form-group">
            <select name="parent_id" class="form-control" title="Родитель">
                <option value="0">Без родителя</option>
                @foreach($parents as $parent)
                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                    @if ($parent->children->count())
                        @foreach($parent->children as $child)
                            <option value="{{ $child->id }}">— {{ $child->name }}</option>
                        @endforeach
                    @endif
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <textarea class="form-control" name="content" placeholder="Краткое описание"
                      maxlength="200" rows="3">{{ old('content') ?? '' }}</textarea>
        </div>
        <div class="form-group">
            <input type="file" class="form-control-file" name="image" accept="image/png, image/jpeg">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </form>
@endsection