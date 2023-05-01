<input 
	id="tggl{{ $item->id }}" 
	class="toggleSwitcher" 
	data-toggle-url="{{ \App\Helpers\RouteHelpers::getToggleRoute($item) }}" 
	data-size     ="small"
	data-toggle   ="toggle"
	data-on       ="Aktiv"
	data-off      ="Deaktiv"
	data-onstyle  ="success"
	data-offstyle ="danger" 
	type="checkbox" @if($item->is_published) checked @endif>

	