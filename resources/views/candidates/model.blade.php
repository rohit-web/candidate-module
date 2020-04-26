<style>
    .pb-cmnt-container {
        font-family: Lato;
        margin-top: 100px;
    }

    .pb-cmnt-textarea {
        resize: none;
        padding: 20px;
        height: 130px;
        width: 100%;
        border: 1px solid #F2F2F2;
    }
    .checked {
        color: orange;
    }
</style>
<div class="tab-content">
    <div id="home" class="tab-pane fade in active">
        <center>
            <img src="/img/avatar.jpeg" width="140" height="140" class="img-circle" />
            <h3 class="media-heading">{{ $candidate->name }} <small>{{ $candidate->location }} &nbsp;&nbsp; 
                @for ($i = 1; $i < 6; $i++)
                    @if($avgRating >= $i)
                        <span class="fa fa-star checked"></span>
                    @else
                        <span class="fa fa-star"></span>
                    @endif
                @endfor
                </small>
            </h3>
            <span><strong>Email Address: </strong></span>
            <span class="label label-warning">{{ $candidate->email }}</span>

            <span><strong>Web Address: </strong></span>
            <span class="label label-warning">{{ $candidate->web_address }}</span>
        </center>
        <hr>
        <center>
            <p class="text-left"><strong>Cover Letter: </strong><br>
            {{ $candidate->cover_letter }}</p>
            <br>
        </center>
    </div>
    <div id="menu1" class="tab-pane fade">
        <div class="row">
            <div class="col-md-12">
                <form class="form-inline" id="commentFormId">
                    <div style="width:100%;margin-bottom:20px;margin-top:20px;">
                        <input id="subject" placeholder="subject" style="width:100%;" required type="text" class="form-control @error('subject') is-invalid @enderror" name="subject" value="{{ old('subject') }}">
                        <input id="candidate_id" required type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                        @error('subject')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <textarea placeholder="Write your comment here!" style="width:100%;margin-bottom:20px;" required name="comment" id="comment" class="form-control pb-cmnt-textarea"></textarea>
                    @error('comment')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    @if(!$ratingIsExist)
                        <div class="form-group">
                            <label for="sel1">Rating:</label>
                            <select class="form-control" id="rating" name="rating">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    @endif
                    <button class="btn btn-primary pull-right" id="submit">Share</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
            <h2 class="page-header">Comments</h2>
                <section class="comment-list">
                <!-- First Comment -->
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
                </section>
            </div>
        </div>
    </div>
    <div id="menu2" class="tab-pane fade">
      <h3>Resume Preview</h3>
      @if (strtolower(pathinfo($candidate->resume_path, PATHINFO_EXTENSION)) == 'pdf')
        <iframe src="{{ asset('uploads') . '/' . $candidate->resume_path }}" width="100%" height="500px">
      @else
        <a href="{{ asset('uploads') . '/' . $candidate->resume_path }}">Download Resume</a>
        <small>PDF files are inline visualization</small>
      @endif
      
    </iframe>
    </div>
  </div>

<script type="text/javascript">
    $(function(){
        $('#commentFormId').on('submit',function(event) {
            event.preventDefault();
            $(this).prop("disabled", true);
            $('#commentFormId').validate();
            $.ajax({
                url: "/comments",
                type:"POST",
                data:{
                    "_token": "{{ csrf_token() }}",
                    subject:$("#subject").val(),
                    candidate_id:$("#candidate_id").val(),
                    comment:$("#comment").val(),
                    rating: $("#rating").val()
                },
                success:function(response){
                    document.getElementById("commentFormId").reset();
                    $("section.comment-list").html(response);
                    console.log(response);
                    $(this).prop("disabled", false);
                }
            });
        });
    });
</script>