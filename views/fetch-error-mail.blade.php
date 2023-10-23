<x-mail::message>
# Something Went Wrong
 
An error occurred in the app.

Here' is the details:

```
{{ $message }}
```

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>