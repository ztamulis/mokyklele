@php
    $count = $model->commentsWithChildrenAndCommenter()->count();
    $comments = $model->commentsWithChildrenAndCommenter()->parentless()->get();
@endphp
<ul id="list-unstyled-{{$model->id}}" class="list-unstyled pl-1">
    @foreach($comments as $comment)
        @include('components.comment.comment-custom')
    @endforeach
</ul>
@if($count > 5)
    <div id="showLess" class="text-center">Rodyti mažiau</div>
    <div id="loadMore" class="text-center">Rodyti daugiau</div>
@endif

<script>
    $(document).ready(function () {
        var size_li = $("#list-unstyled-{{$model->id}} li").length;
        x=3;
        $('#list-unstyled-{{$model->id}} li:lt('+x+')').show();
        $('#loadMore').click(function () {
            x= (x+5 <= size_li) ? x+5 : size_li;
            $('#list-unstyled-{{$model->id}} li:lt('+x+')').show();
        });
        $('#showLess').click(function () {
            x=(x-5<0) ? 3 : x-5;
            $('#list-unstyled-{{$model->id}} li').not(':lt('+x+')').hide();
        });
    });
</script>


