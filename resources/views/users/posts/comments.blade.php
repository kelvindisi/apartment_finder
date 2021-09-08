<div class="row d-flex justify-content-center">
    @foreach($reviews as $review)
    <div class="col-md-10">
        <div class="card p-3 comment_card">
            <div class="d-flex justify-content-between align-items-center">
                <div class="user d-flex flex-row align-items-center">
                    <img src="{{asset('images/avatar.jpg')}}" width="50" class="user-img rounded-circle mr-3">
                    <span>
                        <small class="fw-bold text-primary">
                            {{ $review->booking->user->name}}
                        </small>
                        <small class="fw-bold">{{ $review->review }}</small>
                    </span> 
                </div>
                <small>{{$review->created_at}}</small>
            </div>
        </div>
    </div>
    @endforeach
</div>