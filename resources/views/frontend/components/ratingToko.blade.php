@forelse ($ratingToko as $item)
    <div class="col-sm-12 col-md-6 col-lg-4 card rounded p-4">
        <div class="d-flex justify-content-between align-items-center">
            <p class="fs-5 fw-bold mb-2">{{ $item->nama }}</p>
            <p class="fs-6 mb-2">{{ $item->created_at }}</p>
        </div>
        <div class="d-flex mb-4 gap-1">
            @for ($i = 0; $i < $item->rating_toko; $i++)
                <i class="fas fa-star fa-md text-warning"></i>
            @endfor
            @for ($i = 0; $i < 5 - $item->rating_toko; $i++)
                <i class="far fa-star fa-md text-secondary"></i>
            @endfor
        </div>
        <p class="fs-5">{{ $item->komentar }}</p>
    </div>
@empty
    <div class="bg-warning w-100 d-flex align-items-center flex-column rounded p-3">
        <p class="fs-5 fw-medium text-center">toko ini belum ada yang berkomentar</p>
        <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">tambah
            komentar</button>
    </div>
@endforelse
<div class="d-flex justify-content-center">
    {!! $ratingToko->links() !!}
</div>
