@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('conversations.users', ['users' => $users, 'unread' => $unread])
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">{{ $user->name }}</div>
                <div class="card-body conversations">
                    @if ($messages->hasMorePages())
                        <div class="text-center">
                            <a class="btn btn-light" href="{{ $messages->nextPageUrl() }}">Voir message précédent</a>
                        </div>
                    @endif
                    @foreach (array_reverse($messages->items()) as $message)
                        <div class="row">
                            <div class="col-md-10 {{ $message->from->id !== $user->id ? 'offset-md-2 text-right' : '' }}">
                                <p>
                                    <strong style="font-weight: bold">{{ $message->from->id !== $user->id ? 'Moi' : $message->from->name }}</strong><br>
                                    {!! nl2br(e($message->content)) !!}
                                </p>
                            </div>
                        </div>
                    @endforeach
                    @if ($messages->previousPageUrl())
                        <div class="text-center">
                            <a class="btn btn-light" href="{{ $messages->previousPageUrl() }}">Voir message suivant</a>
                        </div>
                    @endif
                    <form action="" method="post" class="text-center">
                        {{ csrf_field() }}
                        <textarea name="content" class="form-control mb-4 {{ $errors->has('content') ? 'is-invalid' : '' }}" placeholder="Votre message"></textarea>
                        @if ($errors->has('content'))
                            <div class="invalid-feedback">{{ implode(',', $errors->get('content')) }}</div>
                        @endif
                        <button class="btn btn-info btn-block my-4" type="submit">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
