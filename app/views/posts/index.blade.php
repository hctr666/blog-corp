@extends('layouts.default')

@section('title')
    @if (isset($category))
        {{ lang('Categoría:') }} {{ $category->name }} - @parent
    @elseif (isset($tag))
        {{ lang('Etiqueta:') }} {{ $tag->name }} - @parent
    @elseif (isset($user))
        {{ lang('Autor:') }} {{ $user->display_name }} - @parent
    @else
        {{ lang('Todos los posts') }} - @parent
    @endif
@stop

@section('content')

    @if (isset($category))
        <h3 class="filter-header">
            <i class="fa fa-book"></i> {{ lang('Categoría:') }} <span class="label label-default">{{ $category->name }}</span>
        </h3>
    @endif

    @if (isset($tag))
        <h3 class="filter-header">
        <i class="fa fa-tags"></i> {{ lang('Etiqueta:') }} <span class="label label-default">{{{ $tag->name }}}</span>
        </h3>
    @endif

    @if (isset($user))
        <h3 class="filter-header">
        <i class="fa fa-user"></i> {{ lang('Autor:') }} <span class="label label-default">{{{ $user->display_name }}}</span>
        </h3>
    @endif

    <div class="list-group">

    @forelse ($posts as $post)
        <a href="{{ route('posts.show', $post->id) }}" class="list-group-item">
            <h4 class="list-group-item-heading">{{{ $post->title }}}</h4>
            <div class="meta">
                <i class="fa fa-calendar"></i> <span class="timeago">{{ $post->created_at }}</span>
                •  <i class="fa fa-user"></i> {{{ $post->user->display_name }}}
                •  <i class="fa fa-book"></i> {{{ $post->category->name }}}
                •  <i class="fa fa-tags"></i>
                @forelse ($post->tags as $tag)
                    <span class="label label-default">{{{ $tag->name }}}</span>
                @empty
                    N/A
                @endforelse
            </div>
        </a>
    @empty
        {{ lang('¡No hay nada aquí!') }}
    @endforelse

    </div>

    {{ $posts->links(); }}

@stop
