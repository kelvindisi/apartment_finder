<div class="modal fade" id="addImage" tabindex="-1" aria-labelledby="addImage" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addImageLabel">Add New Image</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php
            $params = ['apartment' => $room->apartment->id, 'room'=>$room->id];
        ?>
        <form action="{{ route('rooms.upload', $params) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input type="file" class="form-control-lg" name="image">
            </div>
            <div class="form-group mt-3">
                <button class="btn btn-submit btn-primary btn-lg">Updload</button>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>