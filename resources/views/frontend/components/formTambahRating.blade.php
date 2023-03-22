<p class="fs-3 fw-bold text-capitalize">review</p>
<hr class="mb-4">
<button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample"
    aria-expanded="false" aria-controls="collapseExample">tambah
    komentar</button>
<div class="collapse mt-2" id="collapseExample">
    <div class="w-100 rounded border bg-white p-3 shadow-sm">
        <form action="{{ route('toko.tambahRating') }}" method="post" id="formAction">
            @csrf
            <input type="hidden" value="{{ $tokoKerajinan->id }}" name="fkid_toko">
            <div class="mb-3">
                <label for="nama" class="form-label fs-5 fw-medium">nama</label>
                <input placeholder="nama anda" class="form-control bg-white" name="nama" id="nama" required />
            </div>
            <div class="mb-3">
                <label for="review" class="form-label fs-5 fw-medium">komentar anda</label>
                <textarea placeholder="tambahkan komentar anda" class="form-control bg-white" name="komentar" id="komentar"
                    rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="rating" class="form-label fs-5 fw-medium">rating toko</label>
                <div>
                    <p id="rangeValue" class="fs-5 fw-bold text-primary">0 <i
                            class="fa fa fa-star fa-lg text-warning"></i></p>

                    <Input class="range bg-white" type="range" name="rating" value="0" min="0"
                        max="10" onChange="rangeSlide(this.value)" onmousemove="rangeSlide(this.value)"></Input>
                </div>
            </div>
            <div class="mb-3 pt-3">
                <button type="submit" class="btn btn-primary fs-5 fw-semibold" style="width:250px">Kirim</button>
            </div>
        </form>
    </div>
</div>
