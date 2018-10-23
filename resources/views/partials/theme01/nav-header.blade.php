<div class="dropdown profile-element">
	<img alt="image" class="rounded-circle img-thumbnail img-responsive" src="{{ Auth::user()->getFirstMediaUrl('avatar') ? Auth::user()->getFirstMediaUrl('avatar', 'small') : asset('images/profile.png')  }}" height="90" width="90"/>
	<a data-toggle="dropdown" class="dropdown-toggle" href="#">
		<span class="block m-t-xs font-bold">{{ Auth::user()->username }} <b class="caret"></b> </span>
	</a>
	<span class="text-muted text-xs block" title="user role">{{ Auth::user()->hasAnyRole('') ? Auth::user()->roles[0]['name'] : '' }}</span>
	<ul class="dropdown-menu animated fadeInRight m-t-xs">
		<li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
		<li><a class="dropdown-item" href="contacts.html">Contacts</a></li>
		<li><a class="dropdown-item" href="mailbox.html">Mailbox</a></li>
		<li class="dropdown-divider"></li>
		<li>
			<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
				<i class="fa fa-sign-out"></i>{{ __('Logout') }}
			</a>
		</li>
	</ul>
</div>
<div class="logo-element">
	IN+
</div>
