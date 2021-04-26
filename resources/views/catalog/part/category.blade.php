<div class="col-md-6 mb-4">
    <div class="card">
        <div class="card-header">
            <h4>{{ $root->name }}</h4>
        </div>
        <div class="card-body p-0">
            <img src="https://via.placeholder.com/400x120" alt="" class="img-fluid">
        </div>
        <div class="card-footer">
            <a href="{{ route('catalog.category', ['slug' => $root->slug]) }}"
               class="btn btn-dark">Перейти в раздел</a>
        </div>
    </div>
</div>