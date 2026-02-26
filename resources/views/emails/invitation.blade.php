<p>You have been invited to join <strong>{{ $invitation->colocation->name }}</strong>.</p>
<p>
    <a href="{{ $link }}">Accept Invitation</a>
</p>
<p>If you want to refuse: <a href="{{ route('invitations.refuse', $invitation->token) }}">Refuse</a></p>