<div class="form-check form-switch">
    <input class="form-check-input status" 
    @if($item->status == 1) checked @endif 
    type="checkbox" 
    id="flexSwitchCheckChecked"
    data-toggle-url="{{ \App\Helpers\RouteHelpers::getToggleRoute($item) }}" 
    data-offstyle ="danger" 
     >
    {{-- <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label> --}}
  </div>
