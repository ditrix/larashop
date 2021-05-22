@extends('layout.admin')

@section('content')
    <div class="row">
        <div class="col-6">
            <h1>Все категории</h1>
        </div>
        <div class="col-6">
            <a class="btn btn-primary" href="{{ route('admin.category.create') }}">Новая категория</a>
        </div>
    </div>
    <table class="table table-bordered">
        <tr>
            <th width="30%">Наименование</th>
            <th width="65%">Описание</th>
            <th><i class="fas fa-edit"></i></th>
            <th><i class="fas fa-trash-alt"></i></th>
        </tr>
        @include('admin.category.part.tree', ['items' => $roots, 'level' => -1])
    </table>
@endsection