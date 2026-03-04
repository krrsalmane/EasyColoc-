<div
    style="background-color: #000; color: #4ade80; font-family: 'Courier New', Courier, monospace; padding: 20px; border: 2px solid #166534; border-radius: 5px;">
    <h2 style="color: #4ade80; border-bottom: 1px dotted #166534; padding-bottom: 10px; margin-top: 0;">>>
        SECURE_TRANSMISSION_RECEIVED</h2>
    <p style="font-size: 16px;">TARGET_NODE: <strong>{{ $invitation->colocation->name }}</strong></p>
    <p style="font-size: 14px; color: #22c55e;">> You have been invited to connect to the aforementioned colocation
        node.</p>

    <div style="margin: 25px 0;">
        <p style="margin-bottom: 5px; font-size: 12px; color: #15803d;">// Awaiting your response...</p>
        <a href="{{ $link }}"
            style="display: inline-block; background-color: #14532d; color: #4ade80; text-decoration: none; padding: 10px 20px; border: 1px solid #4ade80; border-radius: 3px; font-weight: bold; margin-right: 15px;">[
            ACCEPT_CONNECTION ]</a>
        <a href="{{ route('invitations.refuse', $invitation->token) }}"
            style="display: inline-block; background-color: transparent; color: #ef4444; border: 1px solid #7f1d1d; text-decoration: none; padding: 10px 20px; border-radius: 3px;">[
            REJECT ]</a>
    </div>

    <hr style="border-top: 1px solid #064e3b; margin: 20px 0;">
    <p style="font-size: 10px; color: #166534;">SYS_MSG: This is an automated message from the EASY_COLOC network. End
        of transmission.</p>
</div>