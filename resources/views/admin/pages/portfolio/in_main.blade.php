<!-- Checked switch -->
<div class="form-check form-switch">
    <input class="form-check-input in_main" style="padding: 15px; width:60px" data-id="{{$item->id}}" type="checkbox" role="switch" id="in_main-{{$item->id}}" @if($item->in_main) checked @endif size="500" />
    <label class="form-check-label" for="in_main-{{$item->id}}"></label>
</div>
  