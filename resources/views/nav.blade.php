@if($menu)
	<div class="menu classic">
		<ul id="nav" class="menu">
			@include('navchildren',['items'=>$menu->roots()])
		</ul>
	</div>
@endif
