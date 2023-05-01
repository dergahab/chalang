
    @foreach ($item->checklist as $checklist)
    <li class="list-group-item d-flex gap-3 border-nonechecklist list-group-item-action justify-content-between">
        <div class="d-flex gap-3 w-100">
            <input  class="form-check-input to-do" @if($item->isCloseToDeadline()) disabled @endif   type="checkbox" @if($checklist->done) checked @endif value="{{$checklist->id}}"   id="todo-{{$checklist->content}}"> 
      
        <label class="form-check-label to-do-text" data-id=" {{$checklist->id}}" width="100%" for="todo{{$checklist->content}}">
            {{$checklist->content}}
        </label> 
        </div>
        @if(!$item->isCloseToDeadline() && Auth::user()->id == $checklist->user_id) 
         <i class="fas fa-trash float-right  display-checklist-delete" data-id="{{$checklist->id}}"></i>
        @endif
    </li>
@endforeach