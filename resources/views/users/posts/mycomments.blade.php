<div class="row mt-4 d-flex justify-content-center">
    @foreach($booking->comments as $comment)
    <div class="col-md-10">
        <div class="card p-3 comment_card">
            <div class="d-flex justify-content-between align-items-center">
                <div class="user d-flex flex-row align-items-center">
                    <img src="{{asset('images/avatar.jpg')}}" width="50" class="user-img rounded-circle mr-3">
                    <span>
                        <small class="fw-bold ">Rating: {{$comment->rating}}</small>
                        <small class="fw-bold">{{ $comment->review }}</small>
                    </span> 
                </div>
                <small>{{ $comment->created_on }}</small>
            </div>
        </div>
    </div>
    @endforeach
</div>