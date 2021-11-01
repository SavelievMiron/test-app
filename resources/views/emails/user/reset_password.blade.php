@component('mail::message')
# Reset Password
Hello,
We've received a request to reset the password for the {{ env('APP_NAME')  }} account associated with {{ $details['user']->email }}. No changes have been made to your account yet.

The token for setting a new password: <strong>{{ $details['token'] }}</strong>

The token expires in two hours after creation.

If you did not request reset a new password, please let us know immediately by replying to this email.

You can find answers to most questions and get in touch with us at support.{{ strtolower(env('APP_NAME')) }}.gmail.com. We are here to help you at any step along the way.

Thanks,<br>
{{ env('APP_NAME') }}
@endcomponent
