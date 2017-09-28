<form action="{{ route('search') }}" method="GET">
	<input type="text" name="search" placeholder="насос" value="{{ request('search') }}">
	<input type="submit" value="Submit">
</form>