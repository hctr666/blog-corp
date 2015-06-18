@extends('layouts.default')

@section('title')
    @if (isset($post))
        {{ lang('Editar Post') }} - @parent
    @else
        {{ lang('Crear Post') }} - @parent
    @endif
@stop

@section('styles')
    {{ HTML::style('assets/editor/simditor.css'); }}
    {{ HTML::style('assets/editor/jquery.tagsinput.min.css'); }}
    {{ HTML::style('assets/editor/simditor-emoji.css'); }}
@stop

@section('content')

    @include('layouts.partials.errors')

    @if (isset($post)) {{ Form::model($post, ['route' => ['posts.update', $post->id], 'method' => 'patch']) }}
    @else {{ Form::open(['route' => 'posts.store', 'method' => 'post']) }}
    @endif

    <div class="form-group">
      {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => lang('El título aquí')]) }}
    </div>

    <div class="form-group">
      {{ Form::select('category_id', $category_selects , Input::old('category_id'), ['class' => 'form-control']) }}
    </div>

    <div class="form-group">
      {{ Form::text('tags', isset($post) ? $post->tagList : null, ['class' => 'form-control', 'style' => "width: 100%; height: 175px;"]) }}
    </div>

    <div class="form-group">
      {{ Form::textarea('body', null, ['class' => 'form-control',
                                        'rows' => 20,
                                        'style' => "overflow:hidden",
                                        'id' => 'editor',
                                        'autofocus' => 'autofocus',
                                        'placeholder' => lang('Empieza el post aquí...')]) }}
    </div>

    <div class="form-group status-post-submit">
        {{ Form::submit(lang('Publicar'), ['class' => 'btn btn-primary', 'id' => 'topic-create-submit']) }}

        @if (isset($post))
            <a class="btn btn-default" href="{{ route('posts.show', $post->id) }}" target="_blank">{{ lang('Ver artículo original') }}</a>
        @endif
    </div>

    {{ Form::close() }}

@stop

@section('scripts')
    {{ HTML::script('assets/editor/simditor-all.js'); }}
    {{ HTML::script('assets/editor/marked.js'); }}
    {{ HTML::script('assets/editor/simditor-marked.js'); }}
    {{ HTML::script('assets/editor/jquery.tagsinput.min.js'); }}
    {{ HTML::script('assets/editor/simditor-emoji.js'); }}

<script>

    $(document).ready(function(){
        var editor = new Simditor({
            textarea: $('#editor'),
            upload: {
                url: '{{ route('posts.upload_image') }}',
                params: null,
                fileKey: 'upload_file',
                connectionCount: 3,
                leaveConfirm: 'Subiendo archivo, se cancelará si dejas la página.'
            },
            pasteImage: true,
            defaultImage: "{{ URL::to('assets/editor/no-preview.jpg'); }}",
            //defaultImage: '{{ cdn("/assets/editor/no-preview.jpg") }}'
            toolbar: ['bold', 'italic', 'underline', 'strikethrough', 'ol', 'ul', 'blockquote', 'code', 'link', 'image', 'indent', 'outdent', 'marked', 'emoji'],
            emoji: {
                //imagePath: '{{ cdn("/assets/editor/images/emoji/") }}'
                imagePath: '{{ URL::to("assets/editor/images/emoji/"); }}'
            }
        });

        $('input[name="tags"]').tagsInput({
            maxTags: 8,
            trimValue: true,
            allowDuplicates: false
        });

    });

    </script>

@stop
