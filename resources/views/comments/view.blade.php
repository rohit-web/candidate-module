@foreach ($candidate->comments as $comment)
    <article class="row">
        <div class="col-md-2 col-sm-2 hidden-xs">
        <figure class="thumbnail">
            <img class="img-responsive" src="/img/user-ava.png" />
            <figcaption class="text-center">{{$comment->user->name}}</figcaption>
        </figure>
        </div>
        <div class="col-md-10 col-sm-10">
            <div class="panel panel-default arrow left">
                <div class="panel-body">
                    <header class="text-left">
                        <div class="comment-user"><i class="fa fa-user"></i> <b>{{$comment->subject}}</b>
                            &nbsp;
                            @if($comment->rating > 0)
                                @for ($i = 1; $i < 6; $i++)
                                    @if($comment->rating >= $i)
                                        <span class="fa fa-star checked"></span>
                                    @else
                                        <span class="fa fa-star"></span>
                                    @endif
                                @endfor
                            @endif
                        </div>

                        <time class="comment-date" datetime="{{$comment->created_at}}"><i class="fa fa-clock-o"></i> {{ date('d-M-Y H:i:s A', strtotime($comment->created_at))}}</time>
                    </header>
                    <div class="comment-post">
                        <p>
                            {{$comment->comment}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </article>
@endforeach 